<?php

namespace App\Controller\Admin;

use App\Entity\Alert;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AlertCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Alert::class;
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
