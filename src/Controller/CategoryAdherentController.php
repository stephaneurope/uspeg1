<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Adherent;
use App\Entity\CategoryAdherent;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class CategoryAdherentController extends AbstractController
{
    

    /**
     * Liste des adhérents par catégorie
     * 
     * 
     * @Route("category/{id}/adherent", name="category_adherent")
     */
    public function index($id)
    {
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $categoryadherent = $repo->find($id);
        $catadherent = $repo->findAll();

        $repo1 = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo1->findAll();
        $repo2 = $this->getDoctrine()->getRepository(Team::class);
        $team1 = $repo2->findAll();


        return $this->render('category_adherent/index.html.twig', [
            'adherent' => $adherent,
            'catadherent' => $catadherent,
            'categoryadherent' => $categoryadherent,
            'team1' => $team1
        ]);
    }

    

    /**
     * Permet de suprimer une catégorie d'adherent
     * 
     * @Route("category/adherent/{id}/delete", name="category_adherent_delete")
     *
     * @param Categoryproduit $categoryadherent
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(CategoryAdherent $categoryadherent, ObjectManager $manager)
    {
        $manager->remove($categoryadherent);
        $manager->flush();
        $this->addFlash(
            'success',
            "La catégorie {$categoryadherent->getTitle()} a bien été supprimée !"
        );

        return $this->redirectToRoute("category_adherent_dashboard");
    }

   
}
