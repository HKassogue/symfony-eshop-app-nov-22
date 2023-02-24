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

        //liste des Reviews
        $listeReview = $this->entityManager->getRepository(Review::class)->findByProduct($product);
        if (!$product) return $this->redirectToRoute('app_home');

        //Enregistrement des Reviews
        if ($_GET != null) {
            $review = new Review();
            $review->setRate($_GET['rate']);
            $review->setComment($_GET['comment']);
            $review->setName($_GET['nom']);
            $review->setEmail($_GET['email']);
            $review->setCreatedAt(new \DateTimeImmutable());
            $review->setProduct($product);
            $this->entityManager->getRepository(Review::class)->save($review, true);
            return $this->redirectToRoute('app_details', [
                'slug' => $slug,
                '_fragment' => 'tab-pane-3'
            ]);
        }

        return $this->render('details/index.html.twig', [
            'product' => $product,
            'listeReview' => $listeReview,
        ]);
    }
}
