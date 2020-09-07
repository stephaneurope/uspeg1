<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Commande;
use Doctrine\Persistence\ObjectManager;
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
    foreach($commande as $c){
       $produit= $c->getproduit()->getId();
       $dateattribution = $c->getdateattribution();
       $code = $c->getproduit()->getcode();
       $title = $c->getproduit()->getTitle();
      
       if ($dateattribution == null) {
          
     
       }
      
      
      
      if ($dateattribution == null) {
        $commandes[]= $title.' | '.'code barre: '.$code.' | '.' Quantité manquante: '.$repo->Essai($produit); 
    }
    }
   
       
    
  
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('print/commande_en_cours.html.twig', [
            'commande' => $commande,
               'commandes' => $commandes
             
    
            ]);
        
        // Load HTML to Dompdf
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


       
        
    }

