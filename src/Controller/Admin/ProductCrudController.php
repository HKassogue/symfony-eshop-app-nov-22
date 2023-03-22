<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('duplicate')
            ->linkToCrudAction('duplicateProduct')
            ->setCssClass('btn btn-info');
        return $actions
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->reorder(Crud::PAGE_EDIT, ['duplicate', Action::SAVE_AND_RETURN]);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name')->hideOnIndex(),  
            MoneyField::new('price')->setCurrency('XOF')->setStoredAsCents(false),
            AssociationField::new('category')->setQueryBuilder(function (QueryBuilder $queryBuilder){
                 $queryBuilder->where('entity.active = true');
            }), 
            IntegerField::new('stock'),
            BooleanField::new('active'),
            TextareaField::new('description')->hideOnIndex(),
            TextEditorField::new('details')->hideOnIndex(),
            DateTimeField::new('created_at')->hideWhenCreating(),
            CollectionField::new('photos')->allowAdd(true)->allowDelete(true)->hideOnIndex(),

        ];
    }

    public function duplicateProduct(AdminContext $context, 
        AdminUrlGenerator $adminUrlGenerator, 
        EntityManagerInterface $entityManager): Response
    {
        /** @var Product $product */
        $product = $context->getEntity()->getInstance();
        $duplicatedProduct = clone $product;
        parent::persistEntity($entityManager, $duplicatedProduct);
        $url = $adminUrlGenerator->setController(self::class)
            ->setAction(Action::DETAIL)
            ->setEntityId($duplicatedProduct->getId())
            ->generateUrl();
        return $this->redirect($url);
    }
}
