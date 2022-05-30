<?php

namespace App\Controller\Admin;

use App\Entity\RecurrenceAide;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecurrenceAideCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RecurrenceAide::class;
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
