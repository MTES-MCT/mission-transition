<?php

namespace App\Command;

use App\Entity\Aid;
use App\Entity\AidAdvisor;
use App\Entity\BusinessActivityArea;
use App\Entity\EnvironmentalAction;
use App\Entity\EnvironmentalTopic;
use App\Entity\Funder;
use App\Entity\Region;
use App\Repository\AidRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class ImportAids extends Command
{
    public const COL_SECONDARY_URL = 1;
    public const COL_PRIMARY_URL = 2;
    public const COL_TYPE = 3;
    public const COL_AID_NAME = 4;
    public const COL_PERIMETER = 5;
    public const COL_REGION = 6;
    public const COL_FUNDER_NAME = 7;
    public const COL_ADVISOR_DESCRIPTION = 8;
    public const COL_ADVISOR_NAME = 9;
    public const COL_ADVISOR_URL = 10;
    public const COL_ADVISOR_ADDRESS = 11;
    public const COL_ADVISOR_EMAIL = 12;
    public const COL_ADVISOR_PHONE = 13;
    public const COL_ADVISOR_FAX = 14;
    public const COL_GOAL = 15;
    public const COL_BENEFICIARY = 16;
    public const COL_AID_DETAILS = 17;
    public const COL_ELIGIBILITY = 18;
    public const COL_CONDITIONS = 19;
    public const COL_FUNDING_TYPES = 20;
    public const COL_APPLICATION_END_DATE = 21;
    public const COL_BUSINESS_ACTIVITY_AREA = 22;
    public const COL_TOPIC_1 = 23;
    public const COL_TOPIC_2 = 24;
    public const COL_ACTION_1 = 25;
    public const COL_ACTION_2 = 26;

    protected static $defaultName = 'app:import-aids-data';

    protected $aidRepository;

    protected $em;

    public function __construct(
        AidRepository $userRepository,
        EntityManagerInterface $em
    ){
        $this->aidRepository = $userRepository;
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
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
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

        $file = fopen($fileName,"r");
        $count = 0;
        $aidAdvisors = [];
        $funders = [];
        $businessActivityAreas = [];
        $environmentalActions = [];
        $environmentalTopics = [];
        $regions = [];

        // skip first line
        fgetcsv($file, 0, ',');
        while ($row = fgetcsv($file, 0, ',')) {
            $output->write('.');
            $aidAdvisor = null;
            $funder = null;
            $state = Aid::STATE_PUBLISHED;

            // Clean values
            $row = array_map(fn(string $value) => trim($value), $row);

            // Creating the aidAdvisor
            if (array_key_exists($row[self::COL_ADVISOR_DESCRIPTION], $aidAdvisors)) {
                $aidAdvisor = $aidAdvisors[$row[self::COL_ADVISOR_DESCRIPTION]];
            } elseif(!empty($row[self::COL_ADVISOR_DESCRIPTION])) {
                $aidAdvisor = new AidAdvisor();
                $aidAdvisor
                    ->setName($row[self::COL_ADVISOR_NAME])
                    ->setDescription($row[self::COL_ADVISOR_DESCRIPTION])
                    ->setEmail($row[self::COL_ADVISOR_EMAIL])
                    ->setPhoneNumber($row[self::COL_ADVISOR_PHONE])
                    ->setWebsite($row[self::COL_ADVISOR_URL])
                    ->setAddress($row[self::COL_ADVISOR_ADDRESS]);
                $aidAdvisors[$row[self::COL_ADVISOR_DESCRIPTION]] = $aidAdvisor;
                $this->em->persist($aidAdvisor);
            }

            // Creating the funder
            if (array_key_exists($row[self::COL_FUNDER_NAME], $funders)) {
                $funder = $funders[$row[self::COL_FUNDER_NAME]];
            } elseif(!empty($row[self::COL_FUNDER_NAME])) {
                $funder = new Funder();
                $funder
                    ->setName($row[self::COL_FUNDER_NAME])
                    ->setWebsite($row[self::COL_ADVISOR_URL]);
                $funders[$row[self::COL_FUNDER_NAME]] = $funder;
                $this->em->persist($funder);
            } else {
                $state = Aid::STATE_DRAFT;
            }

            $aid = new Aid();
            $aid
                ->setName($row[self::COL_AID_NAME])
                ->setAidAdvisor($aidAdvisor)
                ->setFunder($funder)
                ->setAidDetails($row[self::COL_AID_DETAILS])
                ->setGoal($row[self::COL_GOAL])
                ->setBeneficiary($row[self::COL_BENEFICIARY])
                ->setConditions($row[self::COL_CONDITIONS])
                ->setEligibility($row[self::COL_ELIGIBILITY])
                ->setFundingSourceUrl($row[self::COL_PRIMARY_URL] ?? $row[self::COL_SECONDARY_URL])
                ->setPerimeter($row[self::COL_PERIMETER])
                ->setState($state)
                ->setType($row[self::COL_TYPE])
                ->setFundingTypes(explode(', ', $row[self::COL_FUNDING_TYPES]));

            if (!empty($row[self::COL_APPLICATION_END_DATE])) {
                $aid->setApplicationEndDate(\DateTime::createFromFormat('m/d/Y', $row[self::COL_APPLICATION_END_DATE]));
            }

            if (array_key_exists($row[self::COL_ACTION_1], $environmentalActions)) {
                $aid->addEnvironmentalAction($environmentalActions[$row[self::COL_ACTION_1]]);
            } elseif (!empty($row[self::COL_ACTION_1])) {
                $action1 = new EnvironmentalAction();
                $action1
                    ->setName($row[self::COL_ACTION_1])
                    ->addAid($aid);
                $environmentalActions[$row[self::COL_ACTION_1]] = $action1;
                $this->em->persist($action1);
            } else {
                $aid->setState(Aid::STATE_DRAFT);
            }

            if (array_key_exists($row[self::COL_ACTION_2], $environmentalActions)) {
                $aid->addEnvironmentalAction($environmentalActions[$row[self::COL_ACTION_2]]);
            } elseif (!empty($row[self::COL_ACTION_2])) {
                $action2 = new EnvironmentalAction();
                $action2
                    ->setName($row[self::COL_ACTION_2])
                    ->addAid($aid);
                $environmentalActions[$row[self::COL_ACTION_2]] = $action2;
                $this->em->persist($action2);
            }

            if (array_key_exists($row[self::COL_TOPIC_1], $environmentalTopics)) {
                $aid->addEnvironmentalTopic($environmentalTopics[$row[self::COL_TOPIC_1]]);
            } elseif (!empty($row[self::COL_TOPIC_1])) {
                $topic1 = new EnvironmentalTopic();
                $topic1
                    ->setName($row[self::COL_TOPIC_1])
                    ->addAid($aid);
                $environmentalTopics[$row[self::COL_TOPIC_1]] = $topic1;
                $this->em->persist($topic1);
            } else {
                $aid->setState(Aid::STATE_DRAFT);
            }

            if (array_key_exists($row[self::COL_TOPIC_2], $environmentalTopics)) {
                $aid->addEnvironmentalTopic($environmentalTopics[$row[self::COL_TOPIC_2]]);
            } elseif (!empty($row[self::COL_TOPIC_2])) {
                $topic2 = new EnvironmentalTopic();
                $topic2
                    ->setName($row[self::COL_TOPIC_2])
                    ->addAid($aid);
                $environmentalTopics[$row[self::COL_TOPIC_2]] = $topic2;
                $this->em->persist($topic2);
            }

            if (array_key_exists($row[self::COL_BUSINESS_ACTIVITY_AREA], $businessActivityAreas)) {
                $aid->addBusinessActivityArea($businessActivityAreas[$row[self::COL_BUSINESS_ACTIVITY_AREA]]);
            } elseif (!empty($row[self::COL_BUSINESS_ACTIVITY_AREA])) {
                $area = new BusinessActivityArea();
                $area->setName($row[self::COL_BUSINESS_ACTIVITY_AREA]);
                $aid->addBusinessActivityArea($area);
                $businessActivityAreas[self::COL_BUSINESS_ACTIVITY_AREA] = $area;
                $this->em->persist($area);
            }

            if (strcmp($row[self::COL_PERIMETER], 'NATIONAL') === 0 && empty($row[self::COL_REGION])) {
                $aid->setState(Aid::STATE_DRAFT);
            }
            $tempRegions = explode(',', $row[self::COL_REGION]);
            foreach ($tempRegions as $tempRegionName) {
                $tempRegionName = trim($tempRegionName);
                if (array_key_exists($tempRegionName, $regions)) {
                    $aid->addRegion($regions[$tempRegionName]);
                } elseif (!empty($tempRegionName)) {

                    $region = new Region();
                    $region->setName($tempRegionName);
                    $aid->addRegion($region);
                    $regions[$tempRegionName] = $region;
                    $this->em->persist($region);
                }
            }

            $this->em->persist($aid);
            $this->em->flush();

            $count++;
        }

        $output->writeln(PHP_EOL . 'Import done');
        return 1;
    }
}
