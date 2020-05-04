<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Entity\CategoryAdherent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->findAll();
        $repo1 = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo1->findAll();
        return $this->render('home/index.html.twig', [
            'adherent' => $adherent,
            'catadherent'=>$catadherent
        ]);
    }
}
