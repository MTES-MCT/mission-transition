<?php

namespace App\Controller\Admin;

use App\Entity\Aide;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AideCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Aide::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('Informations de l\'aide');
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('nomAide');
        yield TextEditorField::new('description');

        yield FormField::addPanel('Configuration de l\'aide');
        yield AssociationField::new('zonesGeographiques');

    }
}
