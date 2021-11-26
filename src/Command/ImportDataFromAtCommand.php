<?php

namespace App\Command;

use App\Entity\Aid;
use App\Entity\AidType;
use App\Entity\EnvironmentalTopic;
use App\Entity\Funder;
use App\Entity\Region;
use App\Repository\AidRepository;
use App\Repository\AidTypeRepository;
use App\Repository\EnvironmentalTopicRepository;
use App\Repository\FunderRepository;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImportDataFromAtCommand extends Command
{
    const BASE_API_URL = 'https://aides-territoires.beta.gouv.fr/api/aids/?targeted_audiences=private_sector';

    protected static $defaultName = 'app:import-data-from-at';
    protected static $defaultDescription = 'Importing data from AT';

    private HttpClientInterface $client;
    private EntityManagerInterface $em;
    private AidRepository $aidRepository;
    private FunderRepository $funderRepository;
    private RegionRepository $regionRepository;
    private AidTypeRepository $aidTypeRepository;
    private EnvironmentalTopicRepository $environmentalTopicRepository;
    protected int $newlyAdded = 0;
    protected int $newlyUpdated = 0;

    public function __construct(
        HttpClientInterface $client,
        EntityManagerInterface $em,
        AidRepository $aidRepository,
        FunderRepository $funderRepository,
        RegionRepository $regionRepository,
        AidTypeRepository $aidTypeRepository,
        EnvironmentalTopicRepository $environmentalTopicRepository
    ) {
        $this->client = $client;
        $this->em = $em;
        $this->aidRepository = $aidRepository;
        $this->funderRepository = $funderRepository;
        $this->regionRepository = $regionRepository;
        $this->aidTypeRepository = $aidTypeRepository;
        $this->environmentalTopicRepository = $environmentalTopicRepository;
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
        $io->comment('Requesting data from API...');

        $categories = $this->getEnvironmentalTopicsMapping();

        foreach ($categories as $key => $category) {
            $nextUrl = self::BASE_API_URL.$key;
            $io->info($category);
            while (null !== $nextUrl) {
                $response = $this->client->request(
                    'GET',
                    $nextUrl
                );
                $response = $response->toArray();
                $results = $response['results'];

                foreach ($results as $aidFromAt) {
                    $aid = $this->aidRepository->findOneBy([
                        'sourceId' => sprintf('at_%s', $aidFromAt['id']),
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

    protected function createNewAid($aidFromAt): Aid
    {
        $aid = new Aid();
        $aid->setState(Aid::STATE_DRAFT);
        return $this->updateAid($aidFromAt, $aid);
    }

    public function updateAid(array $aidFromAt, Aid $aid): Aid
    {
        if (isset($aidFromAt['financers'][0])) {
            $funder = $this->retrieveExistingeFunder($aidFromAt['financers'][0]);
            if (null === $funder) {
                $funder = $this->createFunder($aidFromAt['financers'][0], $aidFromAt['origin_url']);
                $this->em->persist($funder);
                $this->em->flush();
            }
        } else {
            $funder = null;
        }

        $aid
            ->setSourceId(sprintf('at_%s', $aidFromAt['id']))
            ->setName($aidFromAt['name'])
            ->setFunder($funder)
            ->setApplicationUrl($aidFromAt['application_url'])
            ->setFundingSourceUrl($aidFromAt['origin_url'])
            ->setAidDetails($aidFromAt['description'])
            ->setEligibility($aidFromAt['eligibility'])
            ->setProjectExamples($aidFromAt['project_examples'])
            ->setFundingTypes($aidFromAt['aid_types'])
            ->setApplicationStartDate(new \DateTime($aidFromAt['start_date']))
            ->setApplicationEndDate(isset($aidFromAt['submission_deadline']) ? new \DateTime($aidFromAt['submission_deadline']) : null)
            ->setSourceUpdatedAt(new \DateTime($aidFromAt['date_updated']))
            ->setContactGuidelines($aidFromAt['contact'])
            ->setLoanAmount($aidFromAt['loan_amount'])
            ->setSubventionRateLowerBound($aidFromAt['subvention_rate_lower_bound'])
            ->setSubventionRateUpperBound($aidFromAt['subvention_rate_upper_bound'])
            ->setFundingTypes($aidFromAt['aid_types'])
        ;

        foreach ($aidFromAt['aid_types'] as $aidTypeName) {
            $aidType = $this->retrieveExistingAidType($this->getTypesMapping($aidTypeName));
            if (null === $aidType) {
                $aidType = $this->createAidType($this->getTypesMapping($aidTypeName));
                $this->em->persist($aidType);
                $this->em->flush();
            }

            $aid->addType($aidType);
        }

        return $aid;
    }

    protected function retrieveExistingRegion(string $regionName): ?Region
    {
        return $this->regionRepository->findOneBy([
            'name' => $regionName,
        ]);
    }

    protected function createAidType(string $aidTypeName): AidType
    {
        $aidType = new AidType();
        $aidType
            ->setName($aidTypeName)
        ;

        return $aidType;
    }

    protected function retrieveExistingAidType(string $aidTypeName): ?AidType
    {
        return $this->aidTypeRepository->findOneBy([
            'name' => $aidTypeName,
        ]);
    }

    protected function createRegion(string $regionName): Region
    {
        $region = new Region();
        $region
            ->setName($regionName)
        ;

        return $region;
    }

    protected function retrieveExistingeFunder(string $funderName): ?Funder
    {
        return $this->funderRepository->findOneBy([
            'name' => $funderName,
        ]);
    }

    protected function createFunder(string $funderName, string $funderUrl = null): Funder
    {
        $funder = new Funder();
        $funder
            ->setName($funderName)
            ->setWebsite($funderUrl)
        ;

        return $funder;
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

    protected function getTypesMapping(string $aidTypeName): string
    {
        if (!$aidTypeName) {
            return 'Aide financière';
        }

        $mapping = [
            'Subvention' => 'Aide financière',
            'Prêt' => 'Aide financière',
            'Avance récupérable' => 'Aide financière',
            'Autre' => 'Aide financière',
            'Ingénierie technique' => 'Aide en ingénierie',
            'Ingénierie financière' => 'Aide en ingénierie',
            'Ingénierie Juridique / administrative' => 'Aide en ingénierie',
        ];

        if (isset($mapping[$aidTypeName])) {
            return $mapping[$aidTypeName];
        }

        return 'Aide financière';
    }

    protected function getPerimetersMapping($atRegion): string
    {
        $mapping = [
            'Europe' => 'Continent',
            'France' => Aid::PERIMETER_NATIONAL,
        ];

        if (isset($mapping[$atRegion])) {
            return $mapping[$atRegion];
        }

        return Aid::PERIMETER_REGIONAL;
    }
}
