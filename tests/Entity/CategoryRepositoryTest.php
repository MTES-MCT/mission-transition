<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryRepositoryTest extends KernelTestCase
{
    /** @var EntityManager */
    private $em;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testIfCategoryExists()
    {
        /** @var NestedTreeRepository $categoryRepository */
        $categoryRepository = $this->em->getRepository(Category::class);

        $result = $categoryRepository->findOneBy(['title' => 'Géothermie']);
        $this->assertNotEmpty($result);
    }

    public function testIfParentHasChildren()
    {
        /** @var NestedTreeRepository $categoryRepository */
        $categoryRepository = $this->em->getRepository(Category::class);

        $parent = $categoryRepository->findOneBy(['title' => 'Production d\'énergie']);
        $result = $categoryRepository->getChildren($parent);

        $this->assertCount(3, $result);
    }

    public function testIfCategoryHasCorrectRoot()
    {
        /** @var NestedTreeRepository $categoryRepository */
        $categoryRepository = $this->em->getRepository(Category::class);

        $category = $categoryRepository->findOneBy(['title' => 'Géothermie']);
        $this->assertEquals('Production d\'énergie', $category->getRoot()->getTitle());
    }

    public function testIfCategoryHasCorrectLevel()
    {
        /** @var NestedTreeRepository $categoryRepository */
        $categoryRepository = $this->em->getRepository(Category::class);

        $category = $categoryRepository->findOneBy(['title' => 'Géothermie']);
        $this->assertEquals(2, $category->getLevel());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }
}
