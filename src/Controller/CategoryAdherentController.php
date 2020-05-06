<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Entity\CategoryAdherent;
use App\Form\CategoryAdherentType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryAdherentController extends AbstractController
{
    /**
     * Permet d'afficher le dashboard des categories d'adherent
     * 
     * 
     * @Route("/category/adherent/dashboard", name="category_adherent_dashboard")
     *
     */
    public function dashboard()
    {
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo->findAll();

        return $this->render('category_adherent/dashboard.html.twig', [
            'catadherent' => $catadherent
        ]);
    }

    /**
     * Liste des adhérents par catégorie
     * 
     * 
     * @Route("/category/{id}/adherent", name="category_adherent")
     */
    public function index($id)
    {
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo->find($id);
        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->findAll();


        return $this->render('category_adherent/index.html.twig', [
            'adherent' => $adherent,
            'catadherent' => $catadherent
        ]);
    }

    /**
     * Permet de créer une categorie d'adhérent
     * 
     * @Route("/category/adherent/new", name="category_adherent_create")
     *
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $catadherent = new CategoryAdherent();

        $form = $this->createForm(CategoryAdherentType::class, $catadherent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $manager->persist($catadherent);
            $manager->flush();
            $this->addFlash(
                'success',
                "<strong> La catégorie à bien été ajouter !</strong>"
            );

            return $this->redirectToRoute('category_adherent_dashboard');
        }

        return $this->render('category_adherent/new.html.twig', [
            'form' => $form->createView()
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

    /**
     * Permet de modifier une categorie d'adherent
     *
     * @Route("category/adherent/{id}/modif", name="category_adherent_modif")
     * 
     * @return Response
     */
    public function modif(CategoryAdherent $categoryadherent, Request $request,ObjectManager $manager) {

        
        $form = $this->createForm(CategoryAdherentType::class, $categoryadherent);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categoryadherent);
            $manager->flush();
            $this->addFlash(
                'success',
                "La catégorie {$categoryadherent->getTitle()} a bien été modifiée !"
            );
            return $this->redirectToRoute("category_adherent_dashboard");
        }
        return $this->render('category_adherent/modif.html.twig',[
            'categoryadherent' => $categoryadherent,
            'form' => $form->createView()
    ]);

}
}
