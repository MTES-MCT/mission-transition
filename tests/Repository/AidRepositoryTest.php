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
        $aids = $aidRepository->searchByCriteria(['AAP', 'Aide', 'Fonds'], $environmentalAction1);
        $this->assertEquals(10, count($aids));

        /** @var EnvironmentalAction|null $environmentalAction2 */
        $environmentalAction2 = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Produire mon énergie géothermique',
        ]);
        $aids = $aidRepository->searchByCriteria(['AAP', 'Aide', 'Fonds'], $environmentalAction2);
        $this->assertEquals(20, count($aids));

        /** @var EnvironmentalAction|null $environmentalAction3 */
        $environmentalAction3 = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Produire mon énergie bois/biomasse',
        ]);
        $aids = $aidRepository->searchByCriteria(
            ['AAP', 'Aide', 'Fonds'],
            $environmentalAction2
        );
        $this->assertEquals(20, count($aids));
    }

    public function testAidSearchReturnsOnlyPublishedOnes()
    {
        $aidRepository = $this->entityManager->getRepository(Aid::class);

        /** @var EnvironmentalAction|null $environmentalAction */
        $environmentalAction = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Développer de nouveaux produits ou services durables',
        ]);
        $aids = $aidRepository->searchByCriteria(['AAP', 'Aide', 'Fonds'], $environmentalAction);
        $this->assertEquals(0, count($aids));
    }

    public function testAidSearchBasedOnBusinessActivityArea()
    {
        $aidRepository = $this->entityManager->getRepository(Aid::class);

        /** @var EnvironmentalAction|null $environmentalAction */
        $environmentalAction = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Produire mon énergie géothermique',
        ]);

        /** @var BusinessActivityArea|null $businessActivityArea */
        $businessActivityArea = $this->entityManager->getRepository(BusinessActivityArea::class)->findOneBy([
            'name' => 'Agro-alimentaire',
        ]);
        $aids = $aidRepository->searchByCriteria(['AAP', 'Aide', 'Fonds'], $environmentalAction, [$businessActivityArea->getId()]);
        $this->assertEquals(10, count($aids));
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

        $aids = $aidRepository->searchByCriteria(['AAP', 'Aide', 'Fonds'], $environmentalAction, [], $region);
        $this->assertEquals(10, count($aids));
    }

    public function testAidSearchWithoutCriteria()
    {
        $aidRepository = $this->entityManager->getRepository(Aid::class);

        $aids = $aidRepository->searchByCriteria(['AAP', 'Aide', 'Fonds']);
        $this->assertEquals(0, count($aids));
    }

    public function testAidSearchBasedOnType()
    {
        $aidRepository = $this->entityManager->getRepository(Aid::class);

        /** @var EnvironmentalAction|null $environmentalAction */
        $environmentalAction = $this->entityManager->getRepository(EnvironmentalAction::class)->findOneBy([
            'name' => 'Produire mon énergie géothermique',
        ]);

        $aids = $aidRepository->searchByCriteria(['Premiers Pas'], $environmentalAction);
        $this->assertEquals(10, count($aids));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
