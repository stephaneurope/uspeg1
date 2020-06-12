<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Entity\Role;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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

}