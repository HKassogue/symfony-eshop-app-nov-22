<?php

namespace App\Controller\Admin;

use App\Entity\Alert;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AlertCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Alert::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('status'),
            TextField::new('type'),
            TextareaField::new('details'),
            AssociationField::new('user')->autocomplete(),
            DateTimeField::new('created_at'),
            DateTimeField::new('traited_at')
        ];
    }
    
}
