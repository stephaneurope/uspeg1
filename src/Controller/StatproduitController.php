<?php

namespace App\Controller;


use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\DateCommandes;
use App\Form\DateCommandesType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatproduitController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/statproduit", name="statproduit")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();

        $repo1 = $this->getDoctrine()->getRepository(Produit::class);
        $produit = $repo1->findBy([],['title' => 'ASC']);
        $repodc =$this->getDoctrine()->getRepository(DateCommandes::class);
        $dateCommandes= $repodc->find(2);
      /*foreach($commande->getProduit() as $statproduit) {
        $stat = $statproduit->getTitle();
      }*/
        return $this->render('statproduit/index.html.twig', [
            //'stat'      => $stat,
           'commande'  => $commande,
           'produit'   => $produit,
           'dateCommandes' => $dateCommandes
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/statboutique", name="statboutique")
     */
    public function statistiqueboutique()
    {   

        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();

        $repo1 = $this->getDoctrine()->getRepository(Produit::class);
        $produit = $repo1->findBy([],['title' => 'ASC']);

        $repodc =$this->getDoctrine()->getRepository(DateCommandes::class);
        $dateCommandes= $repodc->find(3);
      
        
      

      /*foreach($commande->getProduit() as $statproduit) {
        $stat = $statproduit->getTitle();
      }*/
        return $this->render('statproduit/statboutique.html.twig', [
            //'stat'      => $stat,
           'commande'         => $commande,
           'produit'          => $produit,
           'dateCommandes'    => $dateCommandes,
           
        ]);
    }


    /**
     * Permet d'imprimer l'inventaire boutique
     * @IsGranted("ROLE_ADMIN")
     * @Route("print/inventaire", name="inventaire")
     */
    public function inventaire()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();

        $repo1 = $this->getDoctrine()->getRepository(Produit::class);
        $produit = $repo1->findBy([],['title' => 'ASC']);
        $repodc =$this->getDoctrine()->getRepository(DateCommandes::class);
        $dateCommandes= $repodc->find(2);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('statproduit/printinventaire.html.twig', [
            'commande' => $commande,
            'produit'   => $produit,
            'dateCommandes' => $dateCommandes
            
        ]);
        // Load HTML to Dompdf essai
        $dompdf->loadHtml($html);
     

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
      
     

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Inventaire.pdf", [
            "Attachment" => true
        ]);
    }


    /**
     * Permet d'imprimer les stats boutique
     * @IsGranted("ROLE_ADMIN")
     * @Route("print/statistique_boutique", name="statistiqueboutique")
     */
    public function statbout()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();

        $repo1 = $this->getDoctrine()->getRepository(Produit::class);
        $produit = $repo1->findBy([],['title' => 'ASC']);
        $repodc =$this->getDoctrine()->getRepository(DateCommandes::class);
        $dateCommandes= $repodc->find(3);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('statproduit/printstatbout.html.twig', [
            'commande' => $commande,
            'produit'   => $produit,
            'dateCommandes' => $dateCommandes
            
        ]);
        // Load HTML to Dompdf essai
        $dompdf->loadHtml($html);
     

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
      
     

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Stats_boutique.pdf", [
            "Attachment" => true
        ]);
    }

/**
     * Permet de modifier les dates de l'inventaire boutique
     * 
     * @Route("statproduit/{id}/edit", name="statproduit/edit2")
     *
     */
    public function edit2(DateCommandes $dateCommandes,Request $request, ObjectManager $manager) {
        $form = $this->createForm(DateCommandesType::class, $dateCommandes);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($dateCommandes);
            $manager->flush();
            $this->addFlash(
                'success',
                "Les dates ont bien étés modifiées !"
            );
            return $this->redirectToRoute("dashboard");
        }
        return $this->render('statproduit/edit2.html.twig',[
            'dateCommandes' => $dateCommandes,
            'form' => $form->createView()
    ]);

    }
    /**
     * Permet de modifier les dates des stats boutique
     * 
     * @Route("statbout/{id}/edit", name="statproduit/edit3")
     *
     */
    public function edit3(DateCommandes $dateCommandes,Request $request, ObjectManager $manager) {
        $form = $this->createForm(DateCommandesType::class, $dateCommandes);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($dateCommandes);
            $manager->flush();
            $this->addFlash(
                'success',
                "Les dates ont bien étés modifiées !"
            );
            return $this->redirectToRoute("dashboard");
        }
        return $this->render('statproduit/edit3.html.twig',[
            'dateCommandes' => $dateCommandes,
            'form' => $form->createView()
    ]);

    }
}
