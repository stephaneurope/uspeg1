<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Entity\CategoryAdherent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryAdherentController extends AbstractController
{
    /**
     * @Route("/category/{id}/adherent", name="category_adherent")
     */
    public function index($id)
    {
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo->find($id);
        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->findAll();
        

        return $this->render('category_adherent/index.html.twig', [
            'adherent' => $adherent,
            'catadherent'=>$catadherent
        ]);
    }
}
