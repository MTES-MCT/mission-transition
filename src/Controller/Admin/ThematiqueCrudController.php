<?php

namespace App\Controller\Admin;

use App\Entity\Thematique;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ThematiqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Thematique::class;
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
