<?php

namespace App\Command;

use App\Entity\Aide;
use App\Entity\EtatAvancementProjet;
use App\Entity\RecurrenceAide;
use App\Entity\TypeAide;
use App\Entity\TypeDepense;
use App\Repository\AideRepository;
use App\Repository\EtatAvancementProjetRepository;
use App\Repository\RecurrenceAideRepository;
use App\Repository\TypeAideRepository;
use App\Repository\TypeDepenseRepository;
use App\Repository\ZoneGeographiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImportDataFromAtCommand extends Command
{
    const BASE_AIDS_API_URL = 'https://aides-territoires.beta.gouv.fr/api/aids/?targeted_audiences=private_sector';
    const BASE_AID_TYPES_API_URL = 'https://aides-territoires.beta.gouv.fr/api/aids/types/';

    protected static $defaultName = 'app:import-data-from-at';
    protected static $defaultDescription = 'Importing data from AT';

    private HttpClientInterface $client;
    private EntityManagerInterface $em;
    private AideRepository $aideRepository;
    private ZoneGeographiqueRepository $zoneGeographiqueRepository;
    private TypeAideRepository $typeAideRepository;
    private TypeDepenseRepository $typeDepenseRepository;
    private RecurrenceAideRepository $recurrenceAideRepository;
    private EtatAvancementProjetRepository $etatAvancementProjetRepository;
    protected int $newlyAdded = 0;
    protected int $newlyUpdated = 0;

    public function __construct(
        HttpClientInterface $client,
        EntityManagerInterface $em,
        AideRepository $aideRepository,
        ZoneGeographiqueRepository $zoneGeographiqueRepository,
        TypeAideRepository $typeAideRepository,
        EtatAvancementProjetRepository $etatAvancementProjetRepository,
        TypeDepenseRepository $typeDepenseRepository,
        RecurrenceAideRepository $recurrenceAideRepository
    ) {
        $this->client = $client;
        $this->em = $em;
        $this->aideRepository = $aideRepository;
        $this->zoneGeographiqueRepository = $zoneGeographiqueRepository;
        $this->typeAideRepository = $typeAideRepository;
        $this->typeDepenseRepository = $typeDepenseRepository;
        $this->recurrenceAideRepository = $recurrenceAideRepository;
        $this->etatAvancementProjetRepository = $etatAvancementProjetRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->comment('Starting Aides-Territoires import.');
        $io->comment('Requesting aid types from API...');
        $this->loadAidTypes();

        $io->comment('Requesting aid data from API...');

        $categories = $this->getEnvironmentalTopicsMapping();

        foreach ($categories as $key => $category) {
            $nextUrl = self::BASE_AIDS_API_URL.$key;
            $io->info($category);
            while (null !== $nextUrl) {
                $response = $this->client->request(
                    'GET',
                    $nextUrl
                );
                $response = $response->toArray();
                $results = $response['results'];

                foreach ($results as $aidFromAt) {
                    $aid = $this->aideRepository->findOneBy([
                        'idSource' => sprintf('at_%s', $aidFromAt['id']),
                    ]);

                    // New Aid
                    if (null === $aid) {
                        $aid = $this->createNewAid($aidFromAt);
                        $this->em->persist($aid);
                        ++$this->newlyAdded;
                    } else {
                        $aid = $this->updateAid($aidFromAt, $aid);
                        ++$this->newlyUpdated;
                    }
                }
                $nextUrl = $response['next'];
            }
            $this->em->flush();
        }

        $io->success(sprintf('Import from Aides-Territoires done with %s new Aids and %s updated', $this->newlyAdded, $this->newlyUpdated));

        return Command::SUCCESS;
    }

    protected function loadAidTypes()
    {
        $response = $this->client->request(
            'GET',
            self::BASE_AID_TYPES_API_URL
        );
        $response = $response->toArray();
        $results = $response['results'];

        foreach ($results as $aidType) {
            $existingAidType = $this->retrieveExistingAidType($aidType['name']);
            if ($existingAidType === null) {
                $newAidType = $this->createAideType($aidType['name'], $aidType['type']);
                $this->em->persist($newAidType);
            }
        }
        $this->em->flush();
    }

    protected function createNewAid($aidFromAt): Aide
    {
        $aid = new Aide();
        return $this->updateAid($aidFromAt, $aid);
    }

    public function updateAid(array $aidFromAt, Aide $aid): Aide
    {
        $aid
            ->setIdSource(sprintf('at_%s', $aidFromAt['id']))
            ->setNomAide($aidFromAt['name'])
            ->setNomAideNormalise($aidFromAt['name'])
            ->setUrlDemarche($aidFromAt['application_url'])
            ->setPorteursAide($aidFromAt['financers'])
            ->setInstructeursAide($aidFromAt['instructors'])
            ->setBeneficicairesAide($aidFromAt['targeted_audiences'])
            ->setProgrammeAides($aidFromAt['programs'])
            ->setUrlDescriptif($aidFromAt['origin_url'])
            ->setAapAmi($aidFromAt['is_call_for_project'])
            ->setDescription($aidFromAt['description'])
            ->setConditionsEligibilite($aidFromAt['eligibility'])
            ->setExempleProjet($aidFromAt['project_examples'])
            ->setDateOuverture(isset($aidFromAt['start_date']) ? new \DateTime($aidFromAt['start_date']) : null)
            ->setDateCloture(isset($aidFromAt['submission_deadline']) ? new \DateTime($aidFromAt['submission_deadline']) : null)
            ->setDateMiseAJour(new \DateTime($aidFromAt['date_updated']))
            ->setContact($aidFromAt['contact'])
            ->setZoneGeographiqueSource($aidFromAt['perimeter'])
            ->setThematiqueSource($aidFromAt['categories'])
            ->setTauxSubventionMinimum($aidFromAt['subvention_rate_lower_bound'])
            ->setTauxSubventionMaximum($aidFromAt['subvention_rate_upper_bound'])
        ;

        foreach ($aidFromAt['aid_types'] as $aidTypeName) {
            $aidType = $this->retrieveExistingAidType($aidTypeName);

            if ($aidType !== null) {
                $aid->addTypesAide($aidType);
            }
        }

        $recurrenceAide = $this->retrieveExistingRecurrence($aidFromAt['recurrence']);
        if ($recurrenceAide === null) {
            $recurrenceAide = $this->createRecurrence($aidFromAt['recurrence']);
        }
        $aid->setRecurrenceAide($recurrenceAide);

        foreach ($aidFromAt['mobilization_steps'] as $mobilizationStepName) {
            $typeDepense = $this->retrieveExistingAvancementProjet($mobilizationStepName);
            if ($typeDepense === null) {
                $typeDepense = $this->createAvancementProjet($mobilizationStepName);
            }
            $aid->addEtatsAvancementProjet($typeDepense);
        }

        foreach ($aidFromAt['destinations'] as $typeDepenseName) {
            $typeDepense = $this->retrieveExistingTypeDepense($typeDepenseName);
            if ($typeDepense === null) {
                $typeDepense = $this->createTypeDepense($typeDepenseName);
            }
            $aid->addTypesDepense($typeDepense);
        }
        return $aid;
    }

    protected function createAideType(string $aidTypeName, string $aidTypeCategory): TypeAide
    {
        $aidType = new TypeAide();
        $aidType
            ->setNom($aidTypeName)
            ->setCategorie($aidTypeCategory)
        ;
        $this->em->persist($aidType);
        $this->em->flush();

        return $aidType;
    }

    protected function retrieveExistingAidType(string $aidTypeName): ?TypeAide
    {
        return $this->typeAideRepository->findOneBy([
            'nom' => $aidTypeName,
        ]);
    }

    protected function createRecurrence(string $recurrenceName): RecurrenceAide
    {
        $recurrenceAide = new RecurrenceAide();
        $recurrenceAide
            ->setNom($recurrenceName)
        ;
        $this->em->persist($recurrenceAide);
        $this->em->flush();
        return $recurrenceAide;
    }

    protected function retrieveExistingRecurrence(string $recurrenceName): ?RecurrenceAide
    {
        return $this->recurrenceAideRepository->findOneBy([
            'nom' => $recurrenceName,
        ]);
    }

    protected function createAvancementProjet(string $etatAvancementName): EtatAvancementProjet
    {
        $etatAvancementProjet = new EtatAvancementProjet();
        $etatAvancementProjet
            ->setNom($etatAvancementName)
        ;

        $this->em->persist($etatAvancementProjet);
        $this->em->flush();

        return $etatAvancementProjet;
    }

    protected function retrieveExistingAvancementProjet(string $etatAvancementName): ?EtatAvancementProjet
    {
        return $this->etatAvancementProjetRepository->findOneBy([
            'nom' => $etatAvancementName,
        ]);
    }

    protected function createTypeDepense(string $typeDepenseName): TypeDepense
    {
        $typeDepense = new TypeDepense();
        $typeDepense
            ->setNom($typeDepenseName)
        ;
        $this->em->persist($typeDepense);
        $this->em->flush();

        return $typeDepense;
    }

    protected function retrieveExistingTypeDepense(string $typeDepenseName): ?TypeDepense
    {
        return $this->typeDepenseRepository->findOneBy([
            'nom' => $typeDepenseName,
        ]);
    }

    protected function getEnvironmentalTopicsMapping(): array
    {
        return [
            '&categories=economie-circulaire' => 'Économie circulaire',
            '&categories=circuits-courts-filieres' => 'Économie circulaire',
            '&categories=economie-denergie' => 'Efficacité énergétique',
            '&categories=recyclage-valorisation' => 'Économie circulaire',
            '&categories=empreinte-carbone' => 'Conservation et restauration des écosystèmes',
            '&categories=assainissement' => 'Conservation et restauration des écosystèmes',
            '&categories=reseaux-de-chaleur' => 'Production et distribution d\'énergie',
            '&categories=limiter-les-deplacements-subis' => 'Limiter les déplacements',
            '&categories=mobilite-partagee' => 'Mobilité partagée',
            '&categories=mobilite-pour-tous' => 'Mobilité pour tous',
            '&categories=amenagement-de-lespace-public-et-modes-actifs' => 'Production et distribution d\'énergie',
            '&categories=transition-energetique' => 'Production et distribution d\'énergie',
            '&categories=biodiversite' => 'Conservation et restauration des écosystèmes',
            '&categories=forets' => 'Conservation et restauration des écosystèmes',
            '&categories=milieux-humides' => 'Conservation et restauration des écosystèmes',
            '&categories=montagne' => 'Conservation et restauration des écosystèmes',
            '&categories=qualite-de-lair' => 'Conservation et restauration des écosystèmes',
            '&categories=risques-naturels' => 'Conservation et restauration des écosystèmes',
            '&categories=sols' => 'Conservation et restauration des écosystèmes',
        ];
    }
}
