<?php

namespace App\Controller\Admin;

use App\Entity\TypeDepense;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypeDepenseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeDepense::class;
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
