<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Entity\CategoryAdherent;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->findAll();
        $repo1 = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo1->findBy([], ['id' => 'ASC']);
        return $this->render('home/index.html.twig', [
            'adherent' => $adherent,
            'catadherent'=>$catadherent
        ]);
    }
}
