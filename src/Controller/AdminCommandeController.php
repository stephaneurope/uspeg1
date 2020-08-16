<?php
namespace App\Controller;


use Doctrine\Persistence\ObjectManager;
use App\Entity\Commande;
use Symfony\Component\Routing\Annotation\Route;
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
        /*$commandes = $manager->createQuery('SELECT adherentId
        ,produitId
      , SUM(qte) as TOTAL_QTE
    FROM App\Entity\Commande  
    GROUP BY adherentId, produitId');

$out = array();

foreach($commandes as $C){
  $out[$C['adherentId']][$C['produitId']] = $C['TOTAL_QTE'];

}*/

        
        return $this->render('admin/commande/a-commandes.html.twig', [
            'commande' => $commande,
            //'commandes' => $out

        ]);
    }
}
