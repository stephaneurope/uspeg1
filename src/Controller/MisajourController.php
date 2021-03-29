<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */
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
