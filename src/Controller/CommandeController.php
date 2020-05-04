<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Entity\Commande;
use App\Entity\Produit;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Command\SecretsSetCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{  
   


    /**
     * Permet de créer une commande
     * 
     * @Route("/commande/adherent/{id}/new/", name="commande_create")
     */
    public function create(Request $request, ObjectManager $manager,$id)
    {  
       
        
        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->find($id);
        
       
     
        
        //$produit = $adherent->set_error_handler;
        
        //pour enlever la commande du stock
        
     
        //fin   
        $commande = new Commande();
        
       
        $form = $this->createForm(CommandeType::class,$commande);

        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
             $p = $form['produit']->getData()->getId();
             $repo1 = $this->getDoctrine()->getRepository(Produit::class);
             $produit = $repo1->find($p);
             dump($produit);
            $stockmoins = $form['qte']->getData();
            
            

           $produit->setQteinit($produit->getQteinit() - $stockmoins);
           
           
            $commande->setAdherent($adherent);
       
          
           $manager->persist($commande);
          
           $manager->flush();
          
           $this->AddFlash(
               'succes',
               "Le produit a bien été enregistré  !"
           );

        }

        return $this->render("commande/create.html.twig",[
            'adherent'=> $adherent,
            'commande' =>$commande,
             'form'=> $form->createView()
        ]);
    }


    /**
     * Permet d'afficher toutes les commandes
     * 
     * @Route("/commande", name="commande")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();

        return $this->render('commande/index.html.twig', [
            'commande' => $commande
            
        ]);
    }

    /**
     * Permet d'afficher un produit d'une commande lié a un adhérent
     * 
     * @Route("/commande/produit/{id}/show", name="commande_show")
     * 
     * @param ProduitRepository $repo
     * @param ObjectManager $manager
     * 
     * @return void 
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->find($id);

        return $this->render('commande/show.html.twig', [
            'commande' => $commande
            
        ]);
    }

    /**
     * Permet d'afficher la liste de commande d'un adherent
     * 
     * @Route("/commande/produit/{id}/edit", name="commande_produit")
     * 
     * @param CommandeRepository $repo
     * @param AdherentRepository $repo2
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function edit($id)
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $repo2 = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo2->find($id);
        $commande = $repo->findAll();
        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'adherent' => $adherent
        ]);
    }

 /**
     * Permet de suprimer un produit
     * 
     * @Route("/commande/produit/{id}/delete", name="commande_delete")
     * 
     * @param ProCommande $commande
     * @param ObjectManager $manager
     * @return Response
     */
    public function produit_delete(Commande $commande, ObjectManager $manager)
    {
        $manager->remove($commande);
        $manager->flush();

        return $this->redirectToRoute("commande");
        

    }

}
