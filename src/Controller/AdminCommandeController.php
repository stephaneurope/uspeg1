<?php
namespace App\Controller;

use App\Entity\Commande;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommandeController extends AbstractController
{
    /**
     * Permet d'afficher toutes les commandes
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
}
