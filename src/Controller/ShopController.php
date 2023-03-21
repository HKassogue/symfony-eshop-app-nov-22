<?php

namespace App\Controller;
use App\Data\Filtre;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use App\Form\FiltreType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
        $category = $cat != 'all' ? $this -> entityManager->getRepository(Category::class)->findBySlug($cat) : null;
        $filtre = new Filtre();
        $filtre->page=$request->get('page',1);
        $products = $this->entityManager->getRepository(Product::class)->search($category, $q);
        $products = $this->entityManager->getRepository(Product::class)->recherche($filtre);
        // dd($products);
        $form = $this->createForm(FiltreType::class, $filtre);
        $form->handleRequest($request);
        return $this->render('shop/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }


}
