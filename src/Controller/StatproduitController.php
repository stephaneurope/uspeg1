<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\DateCommandes;
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
        $dateCommandes= $repodc->find(1);
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
        $dateCommandes= $repodc->find(1);

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

}
