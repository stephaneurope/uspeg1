<?php
namespace App\Controller;

use App\Entity\Adherent;
use App\Entity\Commande;
use App\Entity\Produit;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommandeController extends AbstractController
{
    /**
     * Permet d'afficher toutes les commandes
     * 
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
