<?php

namespace App\Command;

use App\Entity\Aid;
use App\Entity\Region;
use App\Repository\AidRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixingAidsPerimeter extends Command
{
    protected static $defaultName = 'app:fix-perimeter-aids';

    protected $aidRepository;

    protected $em;

    public function __construct(
        AidRepository $aidRepository,
        EntityManagerInterface $em
    ) {
        $this->aidRepository = $aidRepository;
        $this->em = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Fixing aids perimeter.')
        ;
    }

    /**
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Fixing start',
            '============',
            '',
        ]);

        $regionalAids = $this->aidRepository->searchByCriteria(
            [],
        );

        /** @var Aid $aid */
        foreach($regionalAids as $aid) {
            $regions = $aid->getRegions();

            /** @var Region $region */
            foreach ($regions as $region) {
                if ($region->getName() === 'France' || $region->getName() === 'Europe') {
                    $aid->setPerimeter(Aid::PERIMETER_NATIONAL);
                }
            }
        }

        $this->em->flush();

        $output->writeln(PHP_EOL.'Fixing done');

        return 1;
    }
}
