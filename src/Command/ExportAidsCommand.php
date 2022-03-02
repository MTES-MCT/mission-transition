<?php

namespace App\Command;

use App\Repository\AidRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
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

        $outputBuffer = fopen("export_aids.csv", 'w');
        $aids = $this->aidRepository->getAidsArray();
        array_unshift($aids, array_keys(reset($aids)));
        foreach ($aids as $aid) {
            if (!isset($aid['fundingTypes'])) {
                fputcsv($outputBuffer, $aid, ',');
                continue;
            }
            $aid['fundingTypes'] = implode(';', $aid['fundingTypes']);
            $aid['funder'] = implode(';', $aid['funder']);

            foreach ($aid['environmentalTopics'] as $environmentalTopic) {
                $environmentalTopicCategories = $environmentalTopic['environmentalTopicCategories'];
            }

            $environmentalTopicCategoriesNames = array_map(function($topic) {return $topic['name'];}, $environmentalTopicCategories);
            $aid['environmentalTopicsCategories'] = implode(';', $environmentalTopicCategoriesNames);
            $aid['environmentalTopics'] = implode(';', array_map(function($topic) {return $topic['name'] ;}, $aid['environmentalTopics']));
            $aid['applicationEndDate'] = $aid['applicationEndDate'] !== null ? $aid['applicationEndDate']->format(\DateTime::ATOM) : null;
            $aid['applicationStartDate'] = $aid['applicationStartDate'] !== null ? $aid['applicationStartDate']->format(\DateTime::ATOM) : null;
            $aid['createdAt'] = $aid['createdAt'] !== null ? $aid['createdAt']->format(\DateTime::ATOM) : null;
            $aid['updatedAt'] = $aid['updatedAt'] !== null ? $aid['updatedAt']->format(\DateTime::ATOM) : null;
            $aid['deletedAt'] = $aid['deletedAt'] !== null ? $aid['deletedAt']->format(\DateTime::ATOM) : null;
            $aid['sourceUpdatedAt'] = $aid['sourceUpdatedAt'] !== null ? $aid['sourceUpdatedAt']->format(\DateTime::ATOM) : null;
            fputcsv($outputBuffer, $aid, ',');
        }
        fclose($outputBuffer);

        $io->success('Export completes.');

        return Command::SUCCESS;
    }
}
