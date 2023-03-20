<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'), 
            BooleanField::new('active'),
            AssociationField::new('parent')->autocomplete()->setRequired(false),
            ImageField::new('photo')->setRequired(false)
                ->setBasePath('upload/images/categories')
                ->setUploadDir('public/upload/images/categories')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setSortable(false),
            DateTimeField::new('created_at')->hideWhenCreating(),
        ];
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->removeAllProducts();
        $entityInstance->removeAllSubCategories();
        parent::deleteEntity($entityManager, $entityInstance);
    }
}
