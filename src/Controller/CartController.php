<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\CartServices;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    private $cartServices;
    public function __construct(CartServices $cartServices){
        $this->cartServices = $cartServices;
    }
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        $cart = $this->$cartServices->getFullCart();
        if(!isset($cart['products'])){
            return $this->redirectToRoute("app_home");
        }
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart'-> $cart
        ]);
    }

    public function addToCart($id): Response{
        $this->cartServices->addToCart($id);
        return $this->redirectToRoute("app_cart");
    }
}
