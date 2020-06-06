<?php

namespace App\Controller;

use App\Entity\Pack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PackController extends AbstractController
{
    /**
     * Permet d'afficher le pack d'un adherents par rapport a sa catégorie
     * 
     * @Route("/pack/{id}/show", name="pack")
     * 
     * @param PackRepository $repo
     * @param ObjectManager $manager
     * @return void  
     */
    public function index($id)
    {
        $repo = $this->getDoctrine()->getRepository(Pack::class);
        $pack = $repo->find($id);

        return $this->render('pack/index.html.twig', [
            'pack' => $pack
        ]);
    }

   
   
}
