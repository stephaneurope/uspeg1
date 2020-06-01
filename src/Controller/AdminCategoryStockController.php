<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categoryproduit;
use App\Form\CategoryProduitType;
use Doctrine\Persistence\ObjectManager;
use App\Repository\CategoryproduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminCategoryStockController extends AbstractController
{
    /**
     * Permet d'afficher les catégories de produits
     * 
     * @Route("admin/category", name="dash_category")
     * 
     * @param Categoryproduit $categoryproduit
     */
    public function dashboard()
    {
      $repo = $this->getDoctrine()->getRepository(Categoryproduit::class);
      $category = $repo->findAll();
      $repo = $this->getDoctrine()->getRepository(Produit::class);
      $produit = $repo->findAll();
    
        return $this->render('admin/category_stock/dashboard.html.twig', [
            'category' => $category,
            'produit'  => $produit
         
        ]);
    }

    /**
     * Permet d'afficher une seule catégorie
     * 
     * @Route("admin/category/produit/{id}/edit", name="admin/category_produit")
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
        $category = $repo->findAll();
        $produit = $repo2->findAll();
        return $this->render('/admin/category_stock/index.html.twig', [
            'categoryproduit' => $categoryproduit,
            'produit' => $produit,
            'category' =>  $category
        ]);
    }


    /**
     * Permet de créer une catégorie
     * 
     * @Route("/admin/category/new", name="category_create")
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

        return $this->render('admin/category_stock/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * Permet de modifier une categorie
     *
     * @Route("admin/category/{id}/edit", name="category_produit_modif")
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
        return $this->render('admin/category_stock/edit.html.twig',[
            'produit' => $categoryproduit,
            'form' => $form->createView()
    ]);

}

/**
     * Permet de suprimer une catégorie
     * 
     * @Route("admin/category/{id}/delete", name="category_produit_delete")
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

}
