<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\ResetPassType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormError;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;



class AccountController extends AbstractController
{
    /**
     * Permet d'afficher et de gérer le formulaire de connexion
     *  
     * @Route("/login", name="account_login")
     * 
     * 
     * 
     * @return Response
     *  
     */
    public function login(AuthenticationUtils $utils)
    {
        $error =  $utils->getLastAuthenticationError();
     
        $username =$utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error != null,
            'username' => $username

        ]);
    }

    /**
     * Permet de se déconnecter
     *
     * @Route("/logout", name="account_logout")
     * 
     * @IsGranted("ROLE_USER")
     * 
     * @return void
     */
    public function logout()
    {
        
}

/**
     * Permet d'afficher le formulaire d'inscription
     *
     * @Route("/register", name="account_register")
     * 
     * @IsGranted("ROLE_ADMIN")
     * @param AdherentRepository $repo
     * 
     * @return Response
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $repo = $this->getDoctrine()->getRepository(Role::class);
        $adminRole = $repo->find(1);

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $p = $form['add']->getData();

            $hash = $encoder->encodePassword($user,$user->getHash());
            $user->setHash($hash);
           if( $p === 1){
            $user->addUserRole($adminRole);
           }

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le compte a bien été créé ! Le nouvel utilisateur peut maintenant se connectez !"
            );
            return $this->redirectToRoute("home");
        }

        return $this->render('account/registration.html.twig', [
            'form'=> $form->createView()
        ]);
    }
   
    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil
     * 
     * @Route("/account/profile", name="account_profile")
     * @IsGranted("ROLE_USER")
     * 
     *
     * @return Response
     */
    public function profile(Request $request, ObjectManager $manager) {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

          $manager->persist($user);
          $manager->flush();

          $this->addFlash(
            'success',
            "Les données du profils ont été enregistrées avec succés !"
        );
        }

       return $this->render('account/profile.html.twig', [
             'form'=> $form->createView()
       ]);
    }

    /**
     * Permet de modifier un mot de passe
     * 
     * @Route("/account/password-update", name="account_password")
     * 
     * @IsGranted("ROLE_USER")
     * 
     *
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager) {
        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          //1. Vérifier que le oldPassword du formulaire soit le meme que le password de l'utilisateur
          if(!password_verify($passwordUpdate->getOldPassword(), $user->getHash())){
           //Gérer l'erreur
           $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !"));
          } else {
              $newPassword = $passwordUpdate->getNewPassword();
              $hash = $encoder->encodePassword($user, $newPassword);

              $user->setHash($hash);

              $manager->persist($user);
              $manager->flush();

              $this->addFlash(
                'success',
                "Votre mot de passe a bien été modifié !"
              );
              return $this->redirectToRoute('account_password');
          }
          
        }
       

       return $this->render('account/password.html.twig',[
           'form' => $form->createView()
       ]);
    }

    /**
     * Permet d'afficher le profil de l'utilisateur concerné
     * 
     * @Route("/account",name="account_index")
     * 
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    public function myAccount(){
        return $this->render('user/index.html.twig', [
            'user' => $this->getUser()
        ]);
   }

   /**
     * Permet d'afficher la liste des utilisateurs et administrateurs
     * 
     * @Route("/account/utilisateurs",name="account_utilisateur")
     * 
     * 
     * 
     * @return Response
     */
    public function show(UserRepository $user)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findAll();
        return $this->render('account/utilisateur.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/oubli-pass", name="app_forgotten_password")
     */
    public function forgottenPass(Request $request, UserRepository $users, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator
    )
    {
        //On crée le formulaire
        $form = $this->createForm(ResetPassType::class);

        // On traite le formulaire
        $form->handleRequest($request);

        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données
            $donnees = $form->getData();

            // On cherche un utilisateur ayant cet e-mail
            $user = $users->findOneByEmail($donnees['email']);

            // Si l'utilisateur n'existe pas
            if ($user === null) {
                // On envoie une alerte disant que l'adresse e-mail est inconnue
                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');
                
                // On retourne sur la page de connexion
                return $this->redirectToRoute('account_login');

            }
             // On génère un token
             $token = $tokenGenerator->generateToken();

             // On essaie d'écrire le token en base de données
             try{
                 $user->setResetToken($token);
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($user);
                 $entityManager->flush();
             } catch (\Exception $e) {
                 $this->addFlash('warning', $e->getMessage());
                 return $this->redirectToRoute('account_login');
             }
 
             // On génère l'URL de réinitialisation de mot de passe
             $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
              
             // On génère l'e-mail
             $message = (new Email())
            ->from('contact@uspeg-gestion.com')
            ->to($user->getEmail())
            ->subject('Mot de passe oublié')
            ->text('Sending emails is fun again!')
            ->html(
                "Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée pour le site Uspeg-Gestion.fr. Veuillez cliquer sur le lien suivant : <a href='" . $url ."'>ici</a>",
                'text/html'
            )
        ;

        // On envoie l'e-mail
        $mailer->send($message);

        // On crée le message flash de confirmation
        $this->addFlash('message', 'E-mail de réinitialisation du mot de passe envoyé !');

        // On redirige vers la page de login
        return $this->redirectToRoute('account_login');
    }
    // On envoie le formulaire à la vue
    return $this->render('account/forgotten_password.html.twig',['emailForm' => $form->createView()]);
    }

    /**
     * @Route("/reset_pass/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        // On cherche un utilisateur avec le token donné
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);

        // Si l'utilisateur n'existe pas
        if ($user === null) {
            // On affiche une erreur
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('account_login');
        }

        // Si le formulaire est envoyé en méthode post
        if ($request->isMethod('POST')) {
            // On supprime le token
            $user->setResetToken(null);

            // On chiffre le mot de passe
            

            $user->setHash($passwordEncoder->encodePassword($user, $request->request->get('password')));

            // On stocke
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // On crée le message flash
            $this->addFlash('message', 'Mot de passe mis à jour');

            // On redirige vers la page de connexion
            return $this->redirectToRoute('account_login');
        }else {
            // Si on n'a pas reçu les données, on affiche le formulaire
            return $this->render('account/reset_password.html.twig', ['token' => $token]);
        }

    }
}