<?php

namespace App\Controller\Admin;

use App\Entity\EnvironmentalAction;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EnvironmentalActionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EnvironmentalAction::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('un objectif entreprise')
            ->setEntityLabelInPlural('des objectifs entreprises')
            ->setPageTitle('index', 'Gestion %entity_label_plural%')
            ->setPageTitle('edit', fn (EnvironmentalAction $action) => sprintf('Edition de l\'objectif <b>%s</b>', $action->getName()))
            ->setPageTitle('detail', fn (EnvironmentalAction $action) => sprintf('Objectif <b>%s</b>', $action->getName()))
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
