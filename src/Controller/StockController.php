<?php

namespace App\Controller;
use App\Entity\Produit;
use App\Entity\Categoryproduit;
use App\Service\PaginationService;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
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

        return $this->redirectToRoute("admin/produit_edit");
    }

    

   
}
