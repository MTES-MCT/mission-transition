<?php

namespace App\Controller\Admin;

use App\Entity\EnvironmentalTopic;
use App\Entity\EnvironmentalTopicCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EnvironmentalTopicCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EnvironmentalTopicCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie de thématiques')
            ->setEntityLabelInPlural('Catégories de thématique')
            ->setPageTitle('index', 'Gestion des %entity_label_plural%')
            ->setPageTitle('edit', fn (EnvironmentalTopicCategory $topic) => sprintf('Edition de la catégorie <b>%s</b>', $topic->getName()))
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            TextareaField::new('description', 'Description'),
        ];
    }
}
