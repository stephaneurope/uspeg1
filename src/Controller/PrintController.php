<?php

namespace App\Controller;

use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Team;
use App\Entity\Facture;
use App\Entity\Adherent;
use App\Entity\Commande;
use App\Entity\CategoryAdherent;
use App\Entity\Debt;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrintController extends AbstractController
{
    /**
     * @Route("/print", name="print")
     */
    public function index()
    {
        return $this->render('print/index.html.twig', [
            'controller_name' => 'PrintController',
        ]);
    }

    /**
     * Permet d'afficher toutes les produits en commande à commander
     * @IsGranted("ROLE_ADMIN")
     * @Route("print/commande_en_cours", name="commande_en_cours")
     */
    public function Acommande(ObjectManager $manager)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();
        foreach ($commande as $c) {
            $produit = $c->getproduit()->getId();
            $dateattribution = $c->getdateattribution();
            $code = $c->getproduit()->getcode();
            $title = $c->getproduit()->getTitle();

            if ($dateattribution == null) {
            }



            if ($dateattribution == null) {
                $commandes[] = $title . ' | ' . 'code barre: ' . $code . ' | ' . ' Quantité manquante: ' . $repo->Essai($produit);
            }
        }


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('print/commande_en_cours.html.twig', [
            'commande' => $commande,
            'commandes' => $commandes


        ]);

        // Load HTML to Dompdf essai
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Articles_manquants.pdf", [
            "Attachment" => true
        ]);
    }

/**
     * Imprimer la liste des adhérents par catégorie
     * 
     * 
     * @Route("print/{id}/category_adherent", name="print_category_adherent")
     */
    public function categoryAdherent($id)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
      
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $categoryadherent = $repo->find($id);
        $catadherent = $repo->findAll();

        $repo1 = $this->getDoctrine()->getRepository(Adherent::class);
        //$adherent = $repo1->findAll();
        $adherent =$repo1->findBy([],['lastName' => 'ASC']);
        $repo2 = $this->getDoctrine()->getRepository(Team::class);
        $team1 = $repo2->findAll();

         // Retrieve the HTML generated in our twig file
         $html = $this->renderView('print/category_adherent.html.twig', [
            'adherent' => $adherent,
            'catadherent' => $catadherent,
            'categoryadherent' => $categoryadherent,
            'team1' => $team1
        ]);
        // Load HTML to Dompdf essai
        $dompdf->loadHtml($html);
     

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
      
     

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);


    }

/**
     * Permet d'imprimer tous les adherents ayant une commande
     * @IsGranted("ROLE_ADMIN")
     * @Route("print/commande-par-adherent", name="print-commande-par-adherent")
     */
    public function commandeForAdherent(ObjectManager $manager)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();
    
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('print/commande-par-adherent.html.twig', [
            'commande' => $commande,
            
        ]);
        // Load HTML to Dompdf essai
        $dompdf->loadHtml($html);
     

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
      
     

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Adhérent avec au moins une commande.pdf", [
            "Attachment" => true
        ]);
  
    }
      /**
     * Permet d'imprimer toutes les commandes
     * @IsGranted("ROLE_ADMIN")
     * @Route("print/toutes-les-commandes", name="print-commande-en-cours")
     */
    public function commandes()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('print/toutes_les_commandes.html.twig', [
            'commande' => $commande,
            
        ]);
        // Load HTML to Dompdf essai
        $dompdf->loadHtml($html);
     

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
      
     

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Commandes en cours.pdf", [
            "Attachment" => true
        ]);
    }

       
    /**
     * Imprime la liste des adhérents qui n'ont pas payé leur cotisation
     * 
     * 
     * @Route("print/adherent/cotisation", name="adherent_cotisation")
     */
    public function cotisation()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo->findAll();
        $repo1 = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent =$repo1->findBy([],['lastName' => 'ASC']);
       


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('print/cotisation.html.twig', [
            'adherent' => $adherent,
            'catadherent' => $catadherent,
           
           
        ]);

        $dompdf->loadHtml($html);
     

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
      
     

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Liste des adhérents n'ayant pas completement reglé leur cotisation", [
            "Attachment" => true
        ]);
    } 

    /**
     * génère les factures des clients boutique en pdf et les enregistrent dans un dossier
     * 
     * 
     * @Route("print/facture/{id}/boutique", name="facture_boutique")
     */
    public function facture(ObjectManager $manager,$id)
    {
       
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
    
        $repo1 = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo1->findBy(
            ['adherent' => $id,
             'dateattribution' => NULL
            ]           
        );
  
       

        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->find($id);
       


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('print/facture_boutique.html.twig', [
            'adherent' => $adherent,
            'commande' => $commande,
            
           
           
        ]);

        $dompdf->loadHtml($html);
     

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
      
     

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Facture"."-".$adherent->getFirstname()."-".$adherent->getLastname()."-".date("d-m-Y H:i:s"), [
            "Attachment" => true
        ]);
       $pdf_name ="Facture"."-".$adherent->getFirstname()."-".$adherent->getLastname()."-".date("d-m-Y H:i:s");
        //enregistre dans la base de donnée le chemin du pdf
       
       // Store PDF Binary Data
       $output = $dompdf->output();
       
       // In this case, we want to write the file in the public directory
       $publicDirectory = $this->getParameter('kernel.project_dir') . '/public';
       // e.g /var/www/project/public/mypdf.pdf
       $pdfFilepath =  $publicDirectory . '/pdf/factures/facture-'.$adherent->getFirstname()."-".$adherent->getLastname()."-".date('d-m-Y-H-i-s').'.pdf';
       $name = 'facture-'.$adherent->getFirstname()."-".$adherent->getLastname()."-".date('d-m-Y-H-i-s').'.pdf';
       // Write file to the desired path
       file_put_contents($pdfFilepath, $output);
       
       // Send some text response
       //return new Response("The PDF file has been succesfully generated !");
       $repo = $this->getDoctrine()->getRepository(Adherent::class);
       $adherent = $repo->find($id);
       $facture = new facture();
       //$form = $this->createForm(FactureType::class, $facture);
       //$form->handleRequest($request);
       $facture->setAdherent($adherent);
       $facture->setDatefacture(new \DateTime('now'));
       $facture->setPdf($name);
       $manager->persist($facture);
       $manager->flush();

    } 


     

       
    /**
     * Imprime la liste des adhérents qui n'ont pas payé leur cotisation de l'année precedente table debt
     * 
     * 
     * @Route("print/amount/default_payment", name="default_payment_last")
     */
    public function default_payment()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $repo = $this->getDoctrine()->getRepository(Debt::class);
        $debt = $repo->findAll();
        
       


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('print/default_payment.html.twig', [
            'debt' => $debt,
            
           
           
        ]);

        $dompdf->loadHtml($html);
     

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
      
     

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Liste des adhérents n'ayant pas completement reglé leur cotisation l'année précédente", [
            "Attachment" => true
        ]);
    } 


   

}

