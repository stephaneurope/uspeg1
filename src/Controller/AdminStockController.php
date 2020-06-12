<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Entity\Categoryproduit;
use App\Service\PaginationService;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\CategoryproduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminStockController extends AbstractController
{
    /**
     * Permet d'afficher tous les produits 
     * 
     * @Route("admin/stock/produits/{page<\d+>?1}", name="admin/produit_edit")
     * 
     * @param ProduitRepository $repo
     * @param CategoryproduitRepository $repo1
     * @return Response
     */
    public function show_produit(ProduitRepository $repo, CategoryproduitRepository $categoryproduit, $page, PaginationService $pagination)
    {
        $repo1 = $this->getDoctrine()->getRepository(Categoryproduit::class);
        $category = $repo1->findAll();
        $pagination->setEntityClass(Produit::class)
            ->setPage($page);

        return $this->render('admin/stock/show_produit.html.twig', [
            'pagination' => $pagination,
            'category' => $category
        ]);
    }

    /**
     * Permet d'ajouter un produit
     * 
     * @Route("admin/stock/new", name="produit_create")
     *
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $produit = new produit();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        //dd($form->get("imageProduit")->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            //récupère les valeurs sous forme d'objet produit
            $produit = $form->getData();


            //recupere l'image
            $image = $produit->getImageProduit();
            
            if ($image != null) {
            //recupere le file soumis
            $file = $image->getFile();
            
            //je crais un nom unique
           
                $name = md5(uniqid()) . '.' . $file->guessExtension();
            //deplace le fichier
            $file->move($this->getParameter('upload_directory'), $name);
            //je donne le nom a l'image

            $image->setName($name);
            }else{

            } 
            
            $manager->persist($produit);
            $manager->flush();
            $this->addFlash(
                'success',
                "Le produit <strong>{$produit->getTitle()} </strong> a bien été ajouter à la liste des produits !"
            );

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('admin/stock/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * Permet de modifier un produit
     *
     * @Route("/admin/produit/{id}/modif", name="produit_modif")
     * @param ProduitRepository $repo
     * @return Response
     */
    public function modif(Produit $produit, Request $request, ObjectManager $manager,$id)
    {
        $nameold=null;
        $repo = $this->getDoctrine()->getRepository(Produit::class);
            $produit = $repo->find($id);
            if ($produit->getImageProduit() != null) {
                $nameold= $produit->getImageProduit()->getName();
            }else{}
            
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            //récupère les valeurs sous forme d'objet produit
            $produit = $form->getData();

            $imageproduit = $form->get("imageProduit")->getData();
            //dd($imageproduit);die();

            if ($produit->getImageProduit() != null) {
         
                //recupere l'image
                $image = $produit->getImageProduit();
               
                
                if ($image->getFile() != null) {
                //recupere le file soumis
                $file = $image->getFile();
                //je crais un nom unique
                $name = md5(uniqid()) . '.' . $file->guessExtension();
                //deplace le fichier
                $file->move($this->getParameter('upload_directory'), $name);
                //je donne le nom a l'image

                $image->setName($name);
                if ($nameold != null) {
                    unlink("image/produits/$nameold"); //ici je supprime le fichier
                }else{}
               
                }else{}
            } else // aucune nouvelle image envoyée
                //on recupère l'ancienne image

                $produit->setImageProduit($imageproduit);


            $stockplus = $form['stockplus']->getData();


            if (($produit->getQteinit() + $stockplus) >= 0) {
                $produit->setQteinit($produit->getQteinit() + $stockplus);
                $manager->persist($produit);
                $manager->flush();
                $this->addFlash(
                    'success',
                    "Le produit {$produit->getTitle()} a bien été modifié !"
                );


                return $this->redirectToRoute('admin/category_produit', ['id' => $produit->getCategoryproduit()->getId(), 'withAlert' => true]);
            } else $this->AddFlash(
                'danger',
                "Vous n'avez pas assez de produit en stock  !"
            );
        }

        return $this->render('admin/stock/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView()

        ]);
    }
}
