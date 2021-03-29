<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MisajourController extends AbstractController
{
    /**
     * @Route("/misajour", name="misajour")
     */
    public function index()
    {
        return $this->render('misajour/index.html.twig', [
            
        ]);
    }
}
