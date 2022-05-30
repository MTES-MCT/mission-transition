<?php

namespace App\Controller\Admin;

use App\Entity\SousThematique;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SousThematiqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SousThematique::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
