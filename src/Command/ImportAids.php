<?php

namespace App\Command;

use App\Entity\Aid;
use App\Entity\AidAdvisor;
use App\Entity\BusinessActivityArea;
use App\Entity\EnvironmentalAction;
use App\Entity\EnvironmentalTopic;
use App\Entity\EnvironmentalTopicCategory;
use App\Entity\Funder;
use App\Entity\Region;
use App\Repository\AidRepository;
use App\Repository\EnvironmentalTopicCategoryRepository;
use App\Repository\EnvironmentalTopicRepository;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class ImportAids extends Command
{
    public const COL_SOURCE_ID = 0;
    public const COL_REGION = 1;
    public const COL_TOPICS = 2;
    public const COL_FOCUS = 3;

    protected static $defaultName = 'app:import-aids-data';

    protected $aidRepository;
    protected $environmentalTopicCategoryRepository;
    protected $environmentalTopicRepository;
    protected $regionRepository;

    protected $em;

    public function __construct(
        AidRepository          $aidRepository,
        EnvironmentalTopicCategoryRepository $environmentalTopicCategoryRepository,
        EnvironmentalTopicRepository $environmentalTopicRepository,
        RegionRepository $regionRepository,
        EntityManagerInterface $em
    ) {
        $this->aidRepository = $aidRepository;
        $this->environmentalTopicRepository = $environmentalTopicRepository;
        $this->environmentalTopicCategoryRepository = $environmentalTopicCategoryRepository;
        $this->regionRepository = $regionRepository;
        $this->em = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Import aids from csv.')
            ->addArgument('filename', InputArgument::REQUIRED, 'The CSV file to import')
        ;
    }

    /**
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Aids Import',
            '============',
            '',
        ]);

        $fileName = $input->getArgument('filename');

        if (!file_exists($fileName)) {
            throw new FileNotFoundException();
        }

        $file = fopen($fileName, 'r');
        $count = 0;

        // skip first line
        fgetcsv($file, 0, ',');
        while ($row = fgetcsv($file, 0, "\t")) {
            $output->write('.');
            $state = Aid::STATE_PUBLISHED;

            // Clean values
            $row = array_map(fn (string $value) => trim($value), $row);
            $aid = $this->aidRepository->findOneBy(['sourceId' => $row[self::COL_SOURCE_ID]]);
            if (null === $aid) {
                continue;
            }

            $topicsGroup = explode(';', $row[self::COL_TOPICS]);
            foreach($topicsGroup as $group) {
                $categoryAndTopic = explode(' - ', $group);
                if (empty($categoryAndTopic[0]) || empty($categoryAndTopic[1])) {
                    continue;
                }
                $topicCategory = trim($categoryAndTopic[0]);
                $topic = trim($categoryAndTopic[1]);

                $environmentalTopicCategory = $this->environmentalTopicCategoryRepository->findOneBy([
                    'name' => $topicCategory
                ]);

                if (null === $environmentalTopicCategory) {
                    $environmentalTopicCategory = new EnvironmentalTopicCategory();
                    $environmentalTopicCategory->setName($topicCategory);
                    $this->em->persist($environmentalTopicCategory);
                    $this->em->flush();
                }

                $environmentalTopic = $this->environmentalTopicRepository->findOneBy([
                    'name' => $topic
                ]);

                if (null === $environmentalTopic) {
                    $environmentalTopic = new EnvironmentalTopic();
                    $environmentalTopic->setName($topic);
                }

                $environmentalTopic->addAid($aid);
                $environmentalTopic->addEnvironmentalTopicCategory($environmentalTopicCategory);
                $this->em->persist($environmentalTopic);
                $this->em->flush();
            }

            $tempRegions = explode(';', $row[self::COL_REGION]);
            foreach ($tempRegions as $tempRegionName) {
                $tempRegionName = trim($tempRegionName);
                $region = $this->regionRepository->findOneBy(['name' => $tempRegionName]);

                if ($region === null) {
                    $region = new Region();
                    $region->setName($tempRegionName);
                    $this->em->persist($region);
                    $this->em->flush();
                }

                $aid->setPerimeter(($tempRegionName === 'France' || $tempRegionName === 'Europe') ? Aid::PERIMETER_NATIONAL : Aid::PERIMETER_REGIONAL);
                $aid->addRegion($region);
            }

            $aid->setState(Aid::STATE_PUBLISHED);
            $this->em->persist($aid);
            $this->em->flush();

            ++$count;
        }

        $output->writeln(PHP_EOL.'Import done');

        return 1;
    }
}
