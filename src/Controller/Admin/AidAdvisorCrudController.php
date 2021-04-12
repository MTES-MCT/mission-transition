<?php

namespace App\Controller\Admin;

use App\Entity\AidAdvisor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class AidAdvisorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AidAdvisor::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('un conseiller')
            ->setEntityLabelInPlural('des conseillers')
            ->setPageTitle('index', 'Gestion %entity_label_plural%')
            ->setPageTitle('edit', fn (AidAdvisor $aidAdvisor) => sprintf('Edition du conseiller <b>%s</b>', $aidAdvisor->getName()))
            ->setPageTitle('detail', fn (AidAdvisor $aidAdvisor) => sprintf('Conseiller <b>%s</b>', $aidAdvisor->getName()))
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
            TextField::new('name', 'Nom'),
            TextField::new('description', 'Détails'),
            UrlField::new('website', 'Site principal'),
        ];
    }
}
