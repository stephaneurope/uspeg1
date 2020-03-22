<?php

namespace App\Controller;

use App\Entity\Amount;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AmountController extends AbstractController
{
    /**
     * @Route("/amount", name="amount")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Amount::class);
        $amount = $repo->findAll();
        return $this->render('amount/index.html.twig', [
           'amount' => $amount
        ]);
    }

    
}
