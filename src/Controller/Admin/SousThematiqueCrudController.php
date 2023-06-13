<?php

namespace App\Controller\Admin;

use App\Entity\SousThematique;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SousThematiqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SousThematique::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('nom'),
            AssociationField::new('thematiques'),
        ];
    }
}
