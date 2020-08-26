<?php
namespace App\Controller;


use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommandeController extends AbstractController
{
    /**
     * Permet d'afficher toutes les produits distribués et commandés
     * @IsGranted("ROLE_ADMIN")
     * @Route("/commande", name="commande")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();

        return $this->render('admin/commande/index.html.twig', [
            'commande' => $commande

        ]);
    }

    /**
     * Permet d'afficher toutes les commandes
     * @IsGranted("ROLE_ADMIN")
     * @Route("/commande-en-cours", name="commande-en-cours")
     */
    public function commandes()
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();

        return $this->render('admin/commande/commandes.html.twig', [
            'commande' => $commande

        ]);
    }

    /**
     * Permet d'afficher toutes les produits en commande à commander
     * @IsGranted("ROLE_ADMIN")
     * @Route("/a-commande", name="a-commande")
     */
    public function Acommande(ObjectManager $manager)
    {
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
   
       //$commandes = $manager->createQuery('SELECT c, p, sum(c.qte) as cumul  FROM \App\Entity\Commande c INNER JOIN \App\Entity\Produit p WITH  c.dateattribution  IS NULL  GROUP BY p.id')->getScalarResult();
      // $commandes = $manager->createQuery('SELECT p,c, sum(c.qte) as cumul FROM \App\Entity\Produit p INNER JOIN \App\Entity\Commande c WITH c.dateattribution IS NULL GROUP BY p.id')->getScalarResult();

      //$commandes = $manager->createQuery('SELECT adherentId,produitId, SUM(qte) as TOTAL_QTE FROM App\Entity\Commande GROUP BY adherentId, produitId')->getResult();

//$out = array();

/*foreach($commandes as $C){
 $out[$C['adherentId']][$C['produitId']] = $C['TOTAL_QTE'];

}*/
//var_dump($out);
    
        return $this->render('admin/commande/a-commandes.html.twig', [
        'commande' => $commande,
           'commandes' => $commandes
           //'commandes' => $out

        ]);
        
    }
}
