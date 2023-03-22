<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FormEditeProfilType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CompteEditerController extends AbstractController
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    #[Route('/compte/editer', name: 'app_compte_editer')]
    public function index(Request $request, UserPasswordHasherInterface $encoder, ManagerRegistry $registry): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(FormEditeProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $doctrine = new UserRepository($registry);
            $doctrine->save($user, true);
            return new RedirectResponse($this->urlGenerator->generate('app_account'));
        }
        return $this->render('account/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
