<?php

namespace App\Command;

use App\Entity\SousThematique;
use App\Entity\Thematique;
use App\Entity\ZoneGeographique;
use App\Enum\Status;
use App\Repository\AideRepository;
use App\Repository\SousThematiqueRepository;
use App\Repository\ThematiqueRepository;
use App\Repository\ZoneGeographiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class ImportAids extends Command
{
    public const COL_SOURCE_ID = 0;
    public const COL_REGION = 3;
    public const COL_TOPIC = 2;
    public const COL_SUBTOPIC = 1;

    protected static $defaultName = 'app:import-aids-data';

    protected AideRepository $aideRepository;
    protected ThematiqueRepository $thematiqueRepository;
    protected SousThematiqueRepository $sousThematiqueRepository;
    protected ZoneGeographiqueRepository $zoneGeographiqueRepository;

    protected EntityManagerInterface $em;

    public function __construct(
        AideRepository             $aidRepository,
        ThematiqueRepository       $thematiqueRepository,
        SousThematiqueRepository   $sousThematiqueRepository,
        ZoneGeographiqueRepository $zoneGeographiqueRepository,
        EntityManagerInterface     $em
    ) {
        $this->aideRepository = $aidRepository;
        $this->sousThematiqueRepository = $sousThematiqueRepository;
        $this->thematiqueRepository = $thematiqueRepository;
        $this->zoneGeographiqueRepository = $zoneGeographiqueRepository;
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
        while ($row = fgetcsv($file, 0, ",")) {

            // Clean values
            $row = array_map(fn (string $value) => trim($value), $row);
            $aid = $this->aideRepository->findOneBy(['idSource' => $row[self::COL_SOURCE_ID]]);
            if (null === $aid) {
                $output->write(sprintf('Aide %s non trouvée en base de donnée. %s', $row[self::COL_SOURCE_ID], PHP_EOL));
                continue;
            }

            $output->write(sprintf('Aide %s trouvée. Mise à jour en cours... %s', $row[self::COL_SOURCE_ID], PHP_EOL));

            $output->write('.');
            $thematiqueName = $row[self::COL_TOPIC];
            $sousThematiqueName = $row[self::COL_SUBTOPIC];
            $zoneGeographiqueName = $row[self::COL_REGION];

            $thematique = $this->thematiqueRepository->findOneBy([
                'nom' => $thematiqueName,
            ]);

            if ($thematique === null) {
                $output->write(sprintf('Thématique "%s" non trouvée. Création en cours... %s', $thematiqueName, PHP_EOL));
                $thematique = new Thematique();
                $thematique->setNom($thematiqueName);
                $this->em->persist($thematique);
                $this->em->flush();
                $output->write(sprintf('Thématique "%s" créée %s', $thematiqueName, PHP_EOL));
            }

            $output->write(sprintf('Thématique "%s" trouvée. %s', $thematiqueName, PHP_EOL));

            $sousThematique = $this->sousThematiqueRepository->findOneBy([
                'nom' => $sousThematiqueName,
            ]);

            if ($sousThematique === null) {
                $output->write(sprintf('Sous-Thématique "%s" non trouvée. Création en cours... %s', $sousThematiqueName, PHP_EOL));

                $sousThematique = new SousThematique();
                $sousThematique->setNom($sousThematiqueName);
                $sousThematique->addThematique($thematique);
                $this->em->persist($sousThematique);
                $this->em->flush();
                $output->write(sprintf('Sous-Thématique "%s" créée %s', $sousThematiqueName, PHP_EOL));

            }

            $output->write(sprintf('Sous-Thématique "%s" trouvée. %s', $sousThematiqueName, PHP_EOL));


            $zoneGeographique = $this->zoneGeographiqueRepository->findOneBy([
                'nom' => $zoneGeographiqueName,
            ]);

            if ($zoneGeographique === null) {
                $output->write(sprintf('Zone géographique "%s" non trouvée. Création en cours... %s', $zoneGeographiqueName, PHP_EOL));

                $zoneGeographique = new ZoneGeographique();
                $zoneGeographique->setNom($zoneGeographiqueName);
                $this->em->persist($zoneGeographique);
                $this->em->flush();
                $output->write(sprintf('Zone géographique "%s" créée %s', $zoneGeographiqueName, PHP_EOL));

            }

            $output->write(sprintf('Zone géographique "%s" trouvée. %s', $zoneGeographiqueName, PHP_EOL));


            $aid->addSousThematique($sousThematique);
            $aid->addZonesGeographique($zoneGeographique);
            $aid->setEtat(Status::PUBLISHED->value);

            $this->em->flush();

            ++$count;
        }

        $output->writeln(PHP_EOL.'Import done');

        return 1;
    }
}
