<?php

namespace App\Command;

use App\Entity\Aid;
use App\Repository\AidRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExportAidsCommand extends Command
{
    protected static $defaultName = 'app:export-aids';
    protected static $defaultDescription = 'Export aids in CSV';

    protected AidRepository $aidRepository;

    /**
     * @param AidRepository $aidRepository
     */
    public function __construct(AidRepository $aidRepository)
    {
        $this->aidRepository = $aidRepository;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $aids = $this->aidRepository->getAidsArray();

        /** @var Aid $aid */
        foreach ($aids as $aid) {
            $aid['fundingTypes'] = implode(' , ', $aid['fundingTypes']);
            $aid['funder'] = implode(' | ', $aid['funder']);
//            foreach($aid['environmentalTopics'] as $environmentalTopic) {
//                $categories
//                foreach($environmentalTopic['environmentalTopicCategories'] as $environmentalTopicCategory) {
//
//                }
//                $environmentalTopic['environmentalTopicCategories'] = implode(' , ', $environmentalTopic['environmentalTopicCategories']);
//            }
            $aid['environmentalTopics'] = implode(' | ', $aid['environmentalTopics']);
            dd($aid);
        }

        $io->success('Export completes.');

        return Command::SUCCESS;
    }
}
