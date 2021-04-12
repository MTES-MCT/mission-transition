<?php

namespace App\tests;

use App\Entity\Aid;
use App\Entity\BusinessActivityArea;
use App\Entity\EnvironmentalAction;
use App\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AidRepositoryTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testAidSearchByEnvironmentalActions()
    {
        $aidRepository = $this->entityManager->getRepository(Aid::class);

        /** @var EnvironmentalAction|null $environmentalAction1 */
        $environmentalAction1 = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Produire mon énergie solaire',
        ]);
        $aids = $aidRepository->searchByCriteria(
            $this->getFundingTypes(),
            $environmentalAction1,
            null,
            Aid::PERIMETER_REGIONAL,
            100
        );

        $this->assertEquals(10, count($aids));

        /** @var EnvironmentalAction|null $environmentalAction2 */
        $environmentalAction2 = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Produire mon énergie géothermique',
        ]);

        $aids = $aidRepository->searchByCriteria(
            $this->getFundingTypes(),
            $environmentalAction2,
            null,
            Aid::PERIMETER_REGIONAL,
            100
        );
        $this->assertEquals(20, count($aids));

        /** @var EnvironmentalAction|null $environmentalAction3 */
        $environmentalAction3 = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Produire mon énergie bois/biomasse',
        ]);
        $aids = $aidRepository->searchByCriteria(
            $this->getFundingTypes(),
            $environmentalAction3,
            null,
            Aid::PERIMETER_REGIONAL,
            100
        );
        $this->assertEquals(10, count($aids));
    }

    public function testAidSearchReturnsOnlyPublishedOnes()
    {
        $aidRepository = $this->entityManager->getRepository(Aid::class);

        /** @var EnvironmentalAction|null $environmentalAction */
        $environmentalAction = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Développer de nouveaux produits ou services durables',
        ]);
        $aids = $aidRepository->searchByCriteria(
            $this->getFundingTypes(),
            $environmentalAction,
            null,
            Aid::PERIMETER_REGIONAL,
            100
        );
        $this->assertEquals(0, count($aids));
    }

    public function testAidSearchBasedOnRegion()
    {
        $aidRepository = $this->entityManager->getRepository(Aid::class);

        /** @var EnvironmentalAction|null $environmentalAction */
        $environmentalAction = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Acheter/louer dans le numérique responsable',
        ]);

        /** @var Region|null $region */
        $region = $this->entityManager->getRepository(Region::class)->findOneBy([
            'name' => 'Pays de la Loire',
        ]);

        $aids = $aidRepository->searchByCriteria(
            $this->getFundingTypes(),
            $environmentalAction,
            null,
            Aid::PERIMETER_REGIONAL,
            100
        );
        $this->assertEquals(10, count($aids));
    }

    public function testSearchFirstStepsAid()
    {
        $aidRepository = $this->entityManager->getRepository(Aid::class);

        /** @var EnvironmentalAction|null $environmentalAction */
        $environmentalAction = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Produire mon énergie géothermique',
        ]);

        $aids = $aidRepository->searchByCriteria(
            $this->getFirstStepTypes(),
            $environmentalAction,
            null,
            Aid::PERIMETER_REGIONAL,
            100
        );
        $this->assertEquals(10, count($aids));
    }

    public function testSearchNationalAid()
    {
        $aidRepository = $this->entityManager->getRepository(Aid::class);

        /** @var EnvironmentalAction|null $environmentalAction */
        $environmentalAction = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Produire mon énergie géothermique',
        ]);

        $aids = $aidRepository->searchByCriteria(
            $this->getFirstStepTypes(),
            $environmentalAction,
            null,
            Aid::PERIMETER_NATIONAL,
            100
        );
        $this->assertEquals(10, count($aids));
    }

    protected function getFundingTypes() : array
    {
        return ['AAP', 'Aide', 'Fonds'];
    }

    protected function getFirstStepTypes() : array
    {
        return ['Premiers Pas'];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
