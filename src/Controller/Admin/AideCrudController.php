<?php

namespace App\Controller\Admin;

use App\Entity\Aide;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AideCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Aide::class;
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
