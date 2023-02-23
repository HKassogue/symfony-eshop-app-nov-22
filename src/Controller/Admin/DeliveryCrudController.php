<?php

namespace App\Controller\Admin;

use App\Entity\Delivery;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DeliveryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Delivery::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('address'),
            TextField::new('zipcode'),
            TextField::new('city'),
            IntegerField::new('price'),
            TextField::new('state'),
            AssociationField::new('order_')->autocomplete(),
            AssociationField::new('delivered_by')->autocomplete(),
            DateTimeField::new('delivered_at')
        ];
    }
    
}
