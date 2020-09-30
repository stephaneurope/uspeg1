<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="user_show")
     */
    public function index(User $user)
    {
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Permet de suprimer un user
     * 
     * @Route("user/{id}/delete", name="user_delete")
     *
     * @param ObjectManager $manager
     * @param User $user
     * @return Response
     */
    public function delete(ObjectManager $manager,User $user)
    {
      
        $manager->remove($user);
        $manager->flush();
        $this->addFlash(
            'success',
            "L'utilisateur a bien été supprimé !");
            return $this->redirectToRoute("account_utilisateur");
        
    }
}
