<?php

namespace App\Controller\Admin;

use App\Entity\EtatAvancementProjet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EtatAvancementProjetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EtatAvancementProjet::class;
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
