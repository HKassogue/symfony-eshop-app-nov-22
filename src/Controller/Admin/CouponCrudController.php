<?php

namespace App\Controller\Admin;

use App\Entity\Coupon;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CouponCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Coupon::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('code'),
            TextareaField::new('descriptiom'),
            AssociationField::new('coupon_type')->autocomplete(),
            IntegerField::new('discount'),
            IntegerField::new('max_usage'),
            BooleanField::new('is_valide'),
            DateTimeField::new('validity'),
            DateTimeField::new('created_at') 
        ];
    }
   
}
