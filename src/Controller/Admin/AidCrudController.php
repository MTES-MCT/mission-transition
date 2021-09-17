<?php

namespace App\Controller\Admin;

use App\Entity\Aid;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class AidCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Aid::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('un dispositif d\'aide')
            ->setEntityLabelInPlural('des dispositifs d\'aide')
            ->setPageTitle('index', 'Gestion %entity_label_plural%')
            ->setPageTitle('edit', fn (Aid $aid) => sprintf('Edition du dispositif <b>%s</b>', $aid->getName()))
            ->setPageTitle('detail', fn (Aid $aid) => sprintf('Dispositif <b>%s</b>', $aid->getName()))
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID MTE')->onlyOnIndex(),
            ChoiceField::new('state', 'Status')
                ->setChoices([
                    'Brouillon' => Aid::STATE_DRAFT,
                    'Publié' => Aid::STATE_PUBLISHED,
                ]),
            BooleanField::new('directAccess')->setLabel('Fiche sans détails'),
            IdField::new('uuid', 'UUID')->onlyOnDetail(),
            TextField::new('sourceId', 'ID Source')->hideOnForm(),
            TextField::new('name', 'Titre'),
            AssociationField::new('environmentalTopics', 'Thématiques')->setTemplatePath('admin/aid/environmental_topics.html.twig'),
//            AssociationField::new('environmentalActions', 'Actions associées')->setTemplatePath('admin/aid/environmental_actions.html.twig'),
            AssociationField::new('types', 'Types')->setTemplatePath('admin/aid/environmental_topics.html.twig'),
            TextField::new('perimeter', 'Périmètre')->hideOnIndex(),
            AssociationField::new('regions', 'Régions')->autocomplete()->setTemplatePath('admin/aid/environmental_topics.html.twig'),
            TextareaField::new('goal', 'C\'est quoi ?')->hideOnIndex(),
            TextareaField::new('beneficiary', 'Les bénéficiaires')->hideOnIndex(),
            TextareaField::new('aidDetails', 'Accompagnement')->hideOnIndex(),
            TextareaField::new('eligibility', 'Éligibilités')->hideOnIndex(),
            TextareaField::new('conditions', 'Conditions')->hideOnIndex(),
            TextareaField::new('contactGuidelines', 'Contact')->hideOnIndex(),
            UrlField::new('fundingSourceUrl', 'Site Financeur')->hideOnIndex(),
            DateField::new('applicationEndDate', 'Date de cloture')->hideOnIndex(),
            UrlField::new('applicationUrl', 'URL du formulaire de candidature')->hideOnIndex(),
        ];
    }
}
