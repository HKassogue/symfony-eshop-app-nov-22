<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/details/{slug}', name: 'app_details')]
    public function index($slug): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $listeReview = $this->entityManager->getRepository(Review::class)->findByProduct($product);
        if (!$product) return $this->redirectToRoute('app_home');

        return $this->render('details/index.html.twig', [
            'product' => $product,
            'listeReview' => $listeReview,
        ]);
    }
}
