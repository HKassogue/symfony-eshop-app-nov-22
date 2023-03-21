<?php

namespace App\Controller;

use App\Entity\Arrival;
use App\Entity\ArrivalDetails;
use App\Entity\Category;
use App\Entity\Product;
use App\Classe\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // $mail = new Mail();
        // $mail->send('cheicknadiarra378@gmail.com', 'cheickna Diarra', 'premier mail', 'bonjour cheickna j espere que vous allez bien');
        $products = $this->entityManager->getRepository(Product::class)->findByActive(true);
        $arrivals = $this->entityManager->getRepository(Arrival::class)->findByClosed(false);
        $arrivals_details = [];
        foreach($arrivals as $arrival) {
            $arrivals_details += $this->entityManager->getRepository(ArrivalDetails::class)->findByArrival($arrival);
        }
        return $this->render('home/index.html.twig', [
            'products' => $products,
            'arrivals_details' => $arrivals_details
        ]);
    }
}
