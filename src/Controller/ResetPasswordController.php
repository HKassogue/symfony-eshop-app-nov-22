<?php

namespace App\Controller;
use App\Classe\Mail;
use App\Entity\User;
use App\Entity\ResetPassword;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/mot-de-passe-oublié', name: 'app_reset_password')]
    public function index(Request $request): Response
    {
        if($this->getUser()){
        return $this->redirectToRoute('app_home');

        }

        if($request->get('email')){
            // dd($request->get('email'));
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            // dd($user); 
            if($user){
                // I : Enreigistrer dans la table rest_password avec user, token, createdAt
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new \DateTimeImmutable());
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                // 2: envoyer un mail a l'utilisateur avec un lien lui permettant de maj son mot de passe
                $url = 'http://127.0.0.1:8000' . $this->generateUrl('app_update_password', ['token' => $reset_password->getToken()]);

                // $url = $this->generateUrl('reset_password', UrlGeneratorInterface::ABSOLUTE_URL, [
                //     'token' => $reset_password->getToken()]);
                // $link = '<a href="'.$url.'">Réinitialiser le mot de passe</a>';
                
                $content = "Bonjour ".$user->getFirstName()."<br/>Vous avez demandé a réinitialiser votre mot de passe sur le site MULTISHOP.<br/><br/>";
                $content .= "Merci de bien vouloir cliquer sur le lien suivant pour <a href='".$url."'> reinitialiser votre mot de passe</a>";

                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getLastname(), 'Réinitialiser votre mot de passe', $content);

                $this->addFlash('notice', 'vous allez recevoir dans quelques secondes un mail avec la procedure de reinitialiser votre mot de passe.');
            } else {
                $this->addFlash('notice', 'cette adresse email est inconnue.');
            }
        }

        return $this->render('reset_password/index.html.twig');
    }



    #[Route('/modifier-mon-mot-de-passe/{token}', name: 'app_update_password')]
    public function update(Request $request,$token, UserPasswordHasherInterface $encoder)
    {
        // dd($token);
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

        if (!$reset_password){
            return $this->redirectToRoute('app_reset_password');
        }

        //verifier si le createAt = now-3h
        $now = new \DateTimeImmutable();
         if($now > $reset_password->getCreatedAt()->modify('+ 3 hour')){
            // modifier mon mot de passe
            $this->addFlash('notice', 'votre demande de mot de passe a expiré. Merci de la renouveler');
            return $this->redirectToRoute('app_reset_password'); 
         }

        //  dump($now);
        //  dump($reset_password->getCreatedAt()->modify('+ 4 hour'));
        //Rendre une vue avec mot de passse et confirmer votre mot de passe
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $new_pwd = $form->get('new_password')->getData();
            // dd($new_pwd);

        //encodage de mdp
        $password = $encoder->hashPassword($reset_password->getUser(), $new_pwd);
        $reset_password->getUser()->setPassword($password);
                

        //flush en base de données
        $this->entityManager->flush();

        //redirection de l'user vers la page de connexion
        $this->addFlash('notice', 'Votre mot de passe a été bien mis a jour');
        return $this->redirectToRoute('app_login');
        }
        return $this->render('reset_password/update.html.twig', [
            'form' => $form->createView()
        ]);
        
        // dd($reset_password);
    }
}
