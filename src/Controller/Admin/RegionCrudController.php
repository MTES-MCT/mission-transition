<?php

namespace App\Controller\Admin;

use App\Entity\EnvironmentalAction;
use App\Entity\Region;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RegionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Region::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('une région')
            ->setEntityLabelInPlural('des région')
            ->setPageTitle('index', 'Gestion %entity_label_plural%')
            ->setPageTitle('edit', fn (Region $region) => sprintf('Edition de la région <b>%s</b>', $region->getName()))
            ->setPageTitle('detail', fn (Region $region) => sprintf('Objectif <b>%s</b>', $region->getName()))
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
            TextField::new('name', 'Nom')
        ];
    }
}
