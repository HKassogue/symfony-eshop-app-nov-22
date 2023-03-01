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

class ShopController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager= $entityManager;
    }
    #[Route('/shop', name: 'app_shop')]

    public function index()
    {
        $shop = $this -> entityManager->getRepository(Product::class)->findAll();
        $filtre = new filtre();
        $form  = $this -> createForm(FiltreType::class, $filtre);
        return $this->render('shop/index.html.twig', [
            'shop' => $shop,
            'form' => $form ->createView()
        ]);
    }
    #[Route('/shop/{slug}', name: 'app_shop2')]

    public function index1($slug)
    {
        $category = $this -> entityManager->getRepository(Category::class)->findBySlug($slug);
        $shop = $this -> entityManager->getRepository(Product::class)->findByCategory($category);
        $filtre = new filtre();
        $form  = $this -> createForm(FiltreType::class, $filtre);
        return $this->render('shop/slug.html.twig', [
            'shop' => $shop,
            'form' => $form ->createView()
        ]);
    }
}
