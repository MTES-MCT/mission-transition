<?php

namespace App\Controller\Admin;

use App\Entity\Aide;
use App\Form\AidStateFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;

class AideCategoriseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Aide::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(BooleanFilter::new('etat')
                ->setLabel('Etat')
                ->setFormType(AidStateFilterType::class)
            )
            ->add('zonesGeographiques')
        ;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->andWhere($qb->expr()->gt('size(entity.sousThematiques)', 0));
        $qb->andWhere($qb->expr()->gt('size(entity.zonesGeographiques)', 0));
        return $qb;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('Informations de l\'aide');
        yield IdField::new('idSource')
            ->setDisabled()
            ->setLabel('ID de l\'aide')
            ->setHelp('Identifiant local de l\'aide du porteur (unique pour le porteur) au format "at_[IDENTIFIANT]"')
        ;
        yield TextField::new('nomAide')
            ->setDisabled(true)
            ->setLabel('Nom de l\'aide')
            ->setHelp('Nom d\'origine de l\'aide par le porteur')
            ->hideOnIndex()
        ;
        yield TextField::new('nomAideNormalise')
            ->setLabel('Nom de l\'aide normalisé')
            ->setHelp('Visible sur le site. Le titre doit commencer par un verbe à l’infinitif pour que l\'objectif de l\'aide soit explicite.');
        yield DateField::new('dateMiseAJour')
            ->renderAsText()
            ->setFormat('full')
            ->setLabel('Dernière mise à jour AT')
            ->setHelp('Date depuis sa dernière mise à jour venant d\'Aides-Territoires')
            ->setDisabled(true)
            ->hideOnForm()
        ;
        yield BooleanField::new('aapAmi')
            ->setLabel('Appel à projet ?');
        yield TextEditorField::new('description')
            ->setLabel('Description complète de l\'aide et de ses objectifs.')
            ->hideOnIndex()
        ;
        yield TextEditorField::new('exempleProjet')
            ->setLabel('Exemples d\'applications ou de projets réalisés grâce à cette aide.')
            ->setHelp('Ex : Déploiement de services connectés dans un EHPAD à Auzières.')
            ->hideOnIndex()
        ;
        yield TextEditorField::new('conditionsEligibilite')
            ->setLabel('Conditions d\'éligibilité.')
            ->setHelp('Ex : Réservé aux communes de moins de 2000 habitants.')
            ->hideOnIndex()
        ;
        yield TextEditorField::new('contact')
            ->setLabel('Contact(s) pour candidater')
            ->setHelp('Ex : Ecrire un email à aides@programme.gouv.fr')
            ->hideOnIndex()
        ;

        yield FormField::addPanel('Subvention');
        yield IntegerField::new('tauxSubventionMinimum')
            ->setLabel('Taux de subvention minimum')
            ->setHelp('En pourcentage, nombre entier. Ex: 30')
            ->hideOnIndex()
        ;
        yield IntegerField::new('tauxSubventionMaximum')
            ->setLabel('Taux de subvention maximum')
            ->setHelp('En pourcentage, nombre entier. Ex: 70')
            ->hideOnIndex()
        ;
        yield TextEditorField::new('tauxSubventionCommentaire')
            ->setLabel('Commentaire sur les taux de subventions.')
            ->setHelp('Ex : Le taux minimum est soumis à condition.')
            ->hideOnIndex()
        ;


        yield FormField::addPanel('Dates');
        yield DateField::new('dateOuverture')
            ->setLabel('Date d\'ouverture de l\'aide')
        ;
        yield DateField::new('datePreDepot')
            ->setLabel('Date de pré-dépôt de l\'aide.')
            ->hideOnIndex()
        ;
        yield DateField::new('dateCloture')
            ->setLabel('Date de cloture de l\'aide.')
        ;


        yield FormField::addPanel('Configuration de l\'aide');
        yield AssociationField::new('zonesGeographiques')
            ->setLabel('Zone géographique couverte par l\'aide.');
        yield AssociationField::new('etatsAvancementProjet')
            ->setLabel('État d\'avancement du projet pour bénéficier du dispositif.')
            ->hideOnIndex()
        ;
        yield AssociationField::new('typesDepense')
            ->setLabel('Liste des types de dépenses.')
            ->hideOnIndex()
        ;
        yield AssociationField::new('recurrenceAide')
            ->hideOnIndex()
            ->setLabel('Liste des récurrences de l\'aide')
            ->setHelp('rois options : "Permanente" = sans calendrier de candidature, "Ponctuelle" = lancée une seule fois, "Récurrente" = ayant vocation à être relancée plusieurs fois.');
        yield AssociationField::new('sousThematiques')
            ->setLabel('Thématiques')
            ->setHelp('Au format "Thématiques => Sous-Thématiques"')
        ;

        yield FormField::addPanel('Liens externes');
        yield UrlField::new('urlDescriptif')
            ->hideOnIndex()
            ->setLabel('Lien vers le descriptif complet.')
            ->setHelp('Ex : https://aides-territoires.beta.gouv.fr/aides/7ee8-creer-un-agregateur-territorial-a-la-rochelle')
        ;
        yield UrlField::new('urlDemarche')
            ->hideOnIndex()
            ->setLabel('Lien vers la démarche en ligne.')
        ;
    }
}
