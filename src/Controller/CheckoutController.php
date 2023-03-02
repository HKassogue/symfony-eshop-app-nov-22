<?php

namespace App\Controller;
use App\Entity\Delivery;
use App\Form\CheckoutType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class CheckoutController extends AbstractController
{

    #[Route('/checkout', name: 'app_checkout')]
   
    public function addcheck(ManagerRegistry $doctrine,Request $request): Response
    {
        $delivery = new Delivery();
        $form = $this->createForm(CheckoutType::class, $delivery);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->$doctrine->getManager();
            //$delivery= $em->getRepository(Delivery::class)->findALl();
            $em->persist($delivery);
            $em->flush();
        }
        return $this->render('checkout/index.html.twig',[
            "form"=>$form->createView()
        ]);
    }
   
    public function checkout()
    {
            $em = $this->getDoctrine()->getManager();
            $delivery = new Delivery();
            $delivery->setName();
            $delivery->setLastname();
            $delivery->setEmail();
            $delivery->setTel();
            $delivery->setAddress();
            $delivery->setAddress2();
            $delivery->setCountry();
            $delivery->setCity();
            $delivery->setState();
            $delivery->setZipcode();
            $em->persist($delivery);
            $em->flush();
            $this->addFlash("success", "Commande réussie !");
        
        return $this->render('stripe/index.html.twig'/* , [
            "delivery" => $delivery
        ] */);
    }

    
   
}

