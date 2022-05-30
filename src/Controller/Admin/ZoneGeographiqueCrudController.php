<?php

namespace App\Controller\Admin;

use App\Entity\ZoneGeographique;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ZoneGeographiqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ZoneGeographique::class;
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
