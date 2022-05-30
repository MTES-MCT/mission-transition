<?php

namespace App\Controller\Admin;

use App\Entity\TypeAide;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypeAideCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeAide::class;
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
