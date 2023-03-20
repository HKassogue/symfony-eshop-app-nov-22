<?php

namespace App\Controller;
use App\Data\Filtre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\FiltreType;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends AbstractController

{
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/shop', name: 'app_shop')]
    public function index(HttpFoundationRequest $request): Response
    {
        $filtre = new Filtre();
        $filtre->page=$request->get('page',1);
        $form = $this->createForm(FiltreType::class,$filtre);
        $form->handleRequest($request);
        $products = $this->entityManager->getRepository(Product::class)->recherche($filtre);
       // dd($products);
       
        return $this->render('shop/index.html.twig', [
            'products' => $products,
           'form' => $form->createView()
        ]);
    }


}
