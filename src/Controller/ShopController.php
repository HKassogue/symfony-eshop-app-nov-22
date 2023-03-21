<?php

namespace App\Controller;

use App\Classes\filtre;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\FiltreType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ShopController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager= $entityManager;
    }

    #[Route('/shop/{cat}', defaults: ['cat'=>'all'], name: 'app_shop')]
    public function index(Request $request, $cat): Response
    {
        $q = $request->query->get('q', '');
        if(!empty($q)){
            if($cat == 'all') {
                $products = $this->entityManager->getRepository(Product::class)->findBy([
                    'active' => true,
                    'name' => '%'.$q.'%'
                ]);
            }
            else {
                $category = $this -> entityManager->getRepository(Category::class)->findBySlug($cat);
                $products = $this->entityManager->getRepository(Product::class)->findBy([
                    'active' => true,
                    'category' => $category,
                    'name' => '%'.$q.'%'
                ]);
            }
        } 
        else {
            if($cat == 'all') {
                $products = $this->entityManager->getRepository(Product::class)->findByActive(true);
            }
            else {
                $category = $this -> entityManager->getRepository(Category::class)->findBySlug($cat);
                $products = $this->entityManager->getRepository(Product::class)->findBy([
                    'active' => true,
                    'category' => $category
                ]);
            }
        } 
        return $this->render('shop/index.html.twig', [
            'products' => $products,
        ]);
    }
}
