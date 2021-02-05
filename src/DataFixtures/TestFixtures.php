<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    protected static int $order = 1;
    protected static array $groups = ['test'];

    public function load(ObjectManager $manager)
    {
        $this->loadCategories($manager);
    }

    private function loadCategories(ObjectManager $manager)
    {
        $thematique1 = new Category();
        $thematique1->setTitle('Production d\'énergie');

        $thematique2 = new Category();
        $thematique2->setTitle('Contruction Responsable');

        $besoin1 = new Category();
        $besoin1->setTitle('Produire mon énergie');
        $besoin1->setParent($thematique1);

        $besoin2 = new Category();
        $besoin2->setTitle('Distribuer par des réseaux de chaleur');
        $besoin2->setParent($thematique1);

        $sousBesoin1 = new Category();
        $sousBesoin1->setTitle('Géothermie');
        $sousBesoin1->setParent($besoin1);

        $manager->persist($thematique1);
        $manager->persist($thematique2);
        $manager->persist($besoin1);
        $manager->persist($besoin2);
        $manager->persist($sousBesoin1);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
