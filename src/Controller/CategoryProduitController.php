<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categoryproduit;
use App\Form\CategoryProduitType;
use App\Repository\CategoryproduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryProduitController extends AbstractController
{
    /**
     * Permet d'afficher les catégories de produits
     * 
     * @Route("/stock/produit/category", name="dash_category")
     */
    public function dashboard()
    {
      $repo = $this->getDoctrine()->getRepository(Categoryproduit::class);
      $category = $repo->findAll();
    
    
        return $this->render('stock/dashboard.html.twig', [
            'category' => $category
         
        ]);
    }



    /**
     * Permet d'afficher une seule catégorie
     * 
     * @Route("/category/produit/{id}/edit", name="category_produit")
     * 
     * @param CategoryproduitRepository $repo
     * @param ProduitRepository $repo2
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function index($id)
    {
        $repo = $this->getDoctrine()->getRepository(Categoryproduit::class);
        $repo2 = $this->getDoctrine()->getRepository(Produit::class);
        $categoryproduit = $repo->find($id);
        $produit = $repo2->findAll();
        return $this->render('category_produit/index.html.twig', [
            'categoryproduit' => $categoryproduit,
            'produit' => $produit
        ]);
    }

    /**
     * Permet de créer une catégorie
     * 
     * @Route("/category/new", name="category_create")
     * 
     * @return Response
     * 
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $categoryproduit = new Categoryproduit();

        $form = $this->createForm(CategoryProduitType::class, $categoryproduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$manager =$this->getDoctrine()->getManager();

            $manager->persist($categoryproduit);
            $manager->flush();
            $this->addFlash(
                'success',
                "La catégorie <strong>{$categoryproduit->getTitle()} </strong> a bien été ajouter à la liste des catégories !"
            );

            return $this->redirectToRoute('dash_category');
        }

        return $this->render('category_produit/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

      /**
     * Permet de suprimer une catégorie
     * 
     * @Route("category/{id}/delete", name="category_produit_delete")
     *
     * @param Categoryproduit $categoryproduit
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Categoryproduit $categoryproduit, ObjectManager $manager)
    {
        $manager->remove($categoryproduit);
        $manager->flush();
        $this->addFlash(
            'success',
            "La catégorie {$categoryproduit->getTitle()} a bien été supprimée !");

        return $this->redirectToRoute("dash_category");
    }

     /**
     * Permet de modifier une categorie
     *
     * @Route("category/{id}/modif", name="category_produit_modif")
     * 
     * @return Response
     */
    public function modif(Categoryproduit $categoryproduit, Request $request,ObjectManager $manager) {

        
        $form = $this->createForm(CategoryProduitType::class, $categoryproduit);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categoryproduit);
            $manager->flush();
            $this->addFlash(
                'success',
                "La catégorie {$categoryproduit->getTitle()} a bien été modifiée !"
            );
            return $this->redirectToRoute("dash_category");
        }
        return $this->render('stock/produit_modif.html.twig',[
            'produit' => $categoryproduit,
            'form' => $form->createView()
    ]);

}

}
