<?php

namespace App\Controller\Admin;

use App\Entity\CouponType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CouponTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CouponType::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('coupons'),
            DateTimeField::new('created_at')
        ];
    }
    
}
