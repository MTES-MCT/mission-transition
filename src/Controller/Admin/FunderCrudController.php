<?php

namespace App\Controller\Admin;

use App\Entity\Funder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class FunderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Funder::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('un financeur')
            ->setEntityLabelInPlural('des financeurs')
            ->setPageTitle('index', 'Gestion %entity_label_plural%')
            ->setPageTitle('edit', fn (Funder $funder) => sprintf('Edition du financeur <b>%s</b>', $funder->getName()))
            ->setPageTitle('detail', fn (Funder $funder) => sprintf('Financeur <b>%s</b>', $funder->getName()))
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
            UrlField::new('website', 'Site principal'),
        ];
    }
}
