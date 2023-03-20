<?php

namespace App\Controller\Admin;

use App\Entity\OrderDetails;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class OrderDetailsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderDetails::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnform(),
            AssociationField::new('order_')->autocomplete(),
            AssociationField::new('product')->autocomplete(),
            IntegerField::new('quantity'),
            MoneyField::new('price')->setCurrency('XOF'),
        ];
    }
    
}
