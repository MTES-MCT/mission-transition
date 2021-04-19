<?php

namespace App\Controller\Admin;

use App\Entity\EnvironmentalActionCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EnvironmentalActionCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EnvironmentalActionCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('une catégorie d\'objectif')
            ->setEntityLabelInPlural('des catégories d\'objectifs')
            ->setPageTitle('index', 'Gestion %entity_label_plural%')
            ->setPageTitle('edit', fn (EnvironmentalActionCategory $cat) => sprintf('Edition de la catégorie <b>%s</b>', $cat->getName()))
            ->setPageTitle('detail', fn (EnvironmentalActionCategory $cat) => sprintf('Catégorie <b>%s</b>', $cat->getName()))
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
        ];
    }
}
