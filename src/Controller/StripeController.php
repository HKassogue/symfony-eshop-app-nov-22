<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session', name: 'stripe_create_session')]
    public function index(Cart $cart)
    {
        #return $this->render('stripe/index.html.twig', [
        #'controller_name' => 'StripeController',
        #]);
        \Stripe\Stripe::setApiKey('sk_test_51McVkAFVqpwutoMidXKkTjr8ZKBTzzKD3s27Cpn5GNeXEXG3yVkZuSiSF6198dAC6G05FcIA4BpcMqZHRAYjxGNa00rqLNYSQw');

        $products_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000/';

        // foreach($cart->getFull() as $product){

        //     $products_for_stripe[] = \Stripe\Price::create([
        //         'currency' => 'xof',
        //         'unit_amount' => (int) ($product['product']->getPrice() * 100),
        //         'product_data' => [
        //             'name' => $product['product']->getName(),
        //             // 'images' => [$YOUR_DOMAIN."/upload/".$product['product']->getPhotos()],
        //         ],
        //     ]);
        // }

    //     foreach($cart->getFull() as $product){
    //     # Create a new Price object
    //     $price = \Stripe\Price::create([
    //         'currency' => 'xof',
    //         'unit_amount' => (int) ($product['product']->getPrice() * 100),
    //         'product_data' => [
    //             'name' => $product['product']->getName(),
    //         ],
    //     ]);
    // }

        //dd($products_for_stripe);
        \Stripe\Stripe::setApiKey('sk_test_51McVkAFVqpwutoMidXKkTjr8ZKBTzzKD3s27Cpn5GNeXEXG3yVkZuSiSF6198dAC6G05FcIA4BpcMqZHRAYjxGNa00rqLNYSQw');

        // $checkout_session = \Stripe\Checkout\Session::create([
        //     'price_data' => [
        //     $products_for_stripe,
        //     ],
        //     'mode' => 'payment',
        //     'success_url' => $YOUR_DOMAIN . '/success.html',
        //     'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        // ]);

        // $response = new JsonResponse(['id' => $checkout_session->id]);
        // return $response;


    // # Create a new Checkout Session
    //     $checkout_session = \Stripe\Checkout\Session::create([
    //         'line_items' => [
    //         'price'=> $product['product']->getId(),
    //         //'quantity' => 1
    //         ],
    //         'mode' =>'payment',
    //         'success_url' =>'https://example.com/success',
    //         'cancel_url' =>'https://example.com/cancel'
    //     ]);
    //     $response = new JsonResponse(['id' => $checkout_session->id]);
    //     return $response;
    

    $line_items = [];
    foreach ($cart->getFull() as $product) {
        $line_items[] = [
            'price_data' => [
                'currency' => 'xof',
                'unit_amount' => (int) ($product['product']->getPrice()),
                'product_data' => [
                    'name' => $product['product']->getName(),
                ],
            ],
            'quantity' => $product['quantity'],
        ];
    }
    
    $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => $line_items,
        'mode' =>'payment',
        'success_url' =>'https://example.com/success',
        'cancel_url' =>'https://example.com/cancel'
    ]);
    
    $response = new JsonResponse(['id' => $checkout_session->id]);
    return $response;

        




    }
}
