<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{

  

    #[Route('/panier', name: 'app_cart')]
    public function index(Cart $cart)
    {
        
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull()
        ]);
    }

//ROUTE POUR AJOUTER UN ELEMENT AU PANIER
    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id)
    {
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }

//ROUTE POUR SUPPRIMER TOUUUT LE PANIER, test
    #[Route('/cart/remove', name: 'remove_cart')]
    public function remove(Cart $cart)
    {
        $cart->remove();
        return $this->redirectToRoute('app_shop');
    }


    //ROUTE POUR SUPPRIMER UN ELEMENT DU PANIER, test
    #[Route('/cart/delete/{id}', name: 'delete_from_cart')]
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);
        return $this->redirectToRoute('app_cart');
    }

    //ROUTE POUR REDUIRE LA QUANTITE D'UN ELEMENT DU PANIER, test
    #[Route('/cart/decrease/{id}', name: 'decrease_from_cart')]
    public function decrease(Cart $cart, $id)
    {
        $cart->decrease($id);
        return $this->redirectToRoute('app_cart');
    }
    
    #[Route('/cart/applyCoupon/{code}', name: 'apply_Coupon')]
    public function applyCoupon(Cart $cart, Request $request)
    {
        $code = $request->request->get('code');

        if ($cart->applyCoupon($code)) {
            return $this->redirectToRoute('app_cart');
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull(),
            'error' => 'Code de coupon invalide.',
        ]);
    }
}


