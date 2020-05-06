<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Entity\Categoryproduit;
use App\Service\PaginationService;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StockController extends AbstractController
{
    /**
     * Permet d'afficher les catégories de produits
     * 
     * @Route("/stock/category", name="category")
     */
    public function index()
    {
      $repo = $this->getDoctrine()->getRepository(Categoryproduit::class);
      $category = $repo->findAll();
    
    
        return $this->render('stock/index.html.twig', [
            'category' => $category
         
        ]);
    }

    

    /**
     * Permet d'afficher tous les produits produit
     * 
     * @Route("/stock/produits/{page<\d+>?1}", name="produit_edit")
     * 
     * @param ProduitRepository $repo
     * @return Response
     */
    public function show_produit(ProduitRepository $repo,$page, PaginationService $pagination)
    {
        $pagination->setEntityClass(Produit::class)
                   ->setPage($page);

        return $this->render('stock/show_produit.html.twig', [
            'pagination'=> $pagination
        ]);
    }

    /**
     * Permet d'afficher un seul produit
     * 
     * @Route("/stock/produit/{id}/show", name="produit_one_show")
     * 
     * @param ProduitRepository $repo
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function produit_show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Produit::class);
        $produit = $repo->find($id);
       return $this->render('stock/produit_one_show.html.twig', [
            'produit' => $produit
        ]);

    }

    /**
     * Permet de suprimer un produit
     * 
     * @Route("/stock/produit/{id}/delete", name="produit_delete")
     * 
     * @param Produit $produit
     * @param ObjectManager $manager
     * @return Response
     */
    public function produit_delete(Produit $produit, ObjectManager $manager)
    {
        $manager->remove($produit);
        $manager->flush();

        return $this->redirectToRoute("produit_edit");
        

    }

    /**
     * Permet de modifier un produit
     *
     * @Route("produit/{id}/modif", name="produit_modif")
     * 
     * @return Response
     */
    public function modif(Produit $produit, Request $request,ObjectManager $manager) {

        
        $form = $this->createForm(ProduitType::class, $produit);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

          
            $stockplus= $form['stockplus']->getData();
            $produit->setQteinit($produit->getQteinit() + $stockplus);
            $manager->persist($produit);
            $manager->flush();
            $this->addFlash(
                'success',
                "Le produit {$produit->getTitle()} a bien été modifié !"
            );

            return $this->redirectToRoute('category_produit',['id' => $produit->getCategoryproduit()->getId(),'withAlert' => true]);
        }
        return $this->render('stock/produit_modif.html.twig',[
            'produit' => $produit,
            'form' => $form->createView()
    ]);

}


 /**
     * Permet d'ajouter un produit
     * 
     * @Route("produit/new", name="produit_create")
     *
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $adherent = new produit();

        $form = $this->createForm(ProduitType::class, $adherent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$manager =$this->getDoctrine()->getManager();

            $manager->persist($adherent);
            $manager->flush();
            $this->addFlash(
                'success',
                "Le produit <strong>{$adherent->getTitle()} </strong> a bien été ajouter à la liste des produits !"
            );

            return $this->redirectToRoute('produit_edit');
        }

        return $this->render('stock/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
    
}
