<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Entity\Team;
use App\Entity\CategoryAdherent;
use App\Form\CategoryAdherentType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminCategoryAdherentController extends AbstractController
{
    /**
     * @Route("/admin/category/adherent", name="admin_category_adherent")
     */
    public function index()
    {
        return $this->render('admin_category_adherent/index.html.twig', [
            'controller_name' => 'AdminCategoryAdherentController',
        ]);
    }
    /**
     * Permet d'afficher le dashboard des categories d'adherent
     * 
     * 
     * @Route("admin/category-adherent/dashboard", name="category_adherent_dashboard")
     *
     */
    public function dashboard()
    {
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo->findBy([], ['list' => 'ASC']);

        return $this->render('admin/category_adherent/dashboard.html.twig', [
            'catadherent' => $catadherent
        ]);
    }

    /**
     * Liste des adhérents par catégorie
     * 
     * 
     * @Route("admin/category/{id}/adherent", name="admin/category_adherent")
     */
    public function categoryadherent($id)
    {
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $categoryadherent = $repo->find($id);
        $catadherent = $repo->findAll();
        $repo = $this->getDoctrine()->getRepository(Team::class);
        $team1 = $repo->findAll();

        $repo1 = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo1->findAll();

        return $this->render('admin/category_adherent/index.html.twig', [
            'adherent' => $adherent,
            'catadherent' => $catadherent,
            'categoryadherent' => $categoryadherent,
            'team1' => $team1
        ]);
    }

/**
     * Permet de créer une categorie d'adhérent
     * 
     * @Route("admin/category-adherent/new", name="category_adherent_create")
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

        return $this->render('admin/category_adherent/new.html.twig', [
            'form' => $form->createView()
        ]);
    }



     /**
     * Permet de modifier une categorie d'adherent
     *
     * @Route("/admin/category-adherent/{id}/modif", name="category_adherent_modif")
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
        return $this->render('admin/category_adherent/edit.html.twig',[
            'categoryadherent' => $categoryadherent,
            'form' => $form->createView()
    ]);

}
}
