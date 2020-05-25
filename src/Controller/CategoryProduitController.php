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
        $category = $repo->findAll();
        $produit = $repo2->findAll();
        return $this->render('category_produit/index.html.twig', [
            'categoryproduit' => $categoryproduit,
            'produit' => $produit,
            'category'   =>   $category
        ]);
    }

    

      
    

}
