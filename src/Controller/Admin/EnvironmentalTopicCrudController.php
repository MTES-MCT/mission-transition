<?php

namespace App\Controller\Admin;

use App\Entity\EnvironmentalTopic;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EnvironmentalTopicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EnvironmentalTopic::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Thématique')
            ->setEntityLabelInPlural('Thématiques')
            ->setPageTitle('index', 'Gestion des %entity_label_plural%')
            ->setPageTitle('edit', fn (EnvironmentalTopic $topic) => sprintf('Edition de la thématique <b>%s</b>', $topic->getName()))
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
        ];
    }
}
