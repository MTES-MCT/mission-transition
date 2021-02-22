<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Aid;
use App\Entity\EnvironmentalAction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    public const TAG_CHALEUR = 'tag-chaleur';
    public const TAG_ENERGIE = 'tag-energie';

    public function load(ObjectManager $manager)
    {
        $this->loadCategories($manager);
        $this->loadTags($manager);
        $this->loadFundraisingCards($manager);
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

    public function loadTags(ObjectManager $manager)
    {
        $tagChaleur = new EnvironmentalAction('chaleur');
        $tagEnergie = new EnvironmentalAction('energie');

        $manager->persist($tagChaleur);
        $manager->persist($tagEnergie);
        $manager->flush();

        $this->setReference(self::TAG_CHALEUR, $tagChaleur);
        $this->setReference(self::TAG_ENERGIE, $tagEnergie);
    }

    public function loadFundraisingCards(ObjectManager $manager)
    {
        $fundraisingCard = new Aid();
        $fundraisingCard
            ->setName('installations de production d\'eau chaude solaire')
            ->setDescription("Vous êtes propriétaire de logements collectifs, en particulier dans le logement social. 
Vous êtes une entreprise dans le secteur tertiaire, industriel ou agricole.")
            ->addTag($this->getReference(self::TAG_CHALEUR))
            ->addTag($this->getReference(self::TAG_ENERGIE))
            ->setEligibility("Préalablement à votre projet d’investissement, une étude de faisabilité est 
            nécessaire pour qualifier le dimensionnement de l’installation et apporter l’information sur la productivité 
            solaire utile de l’installation projetée. Si vous n’avez pas encore réalisé cette étude, vous trouverez le 
            cahier des charges en modifiant vos critères de recherche (filtre « Études ») ci-dessus.")
            ->setState('draft')
        ;

        $manager->persist($fundraisingCard);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
