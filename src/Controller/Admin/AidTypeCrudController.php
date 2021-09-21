<?php

namespace App\Controller\Admin;

use App\Entity\AidType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AidTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AidType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }
}
