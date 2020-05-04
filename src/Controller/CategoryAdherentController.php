<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryAdherentController extends AbstractController
{
    /**
     * @Route("/category/adherent", name="category_adherent")
     */
    public function index()
    {
        return $this->render('category_adherent/index.html.twig', [
            
        ]);
    }
}
