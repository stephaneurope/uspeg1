<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Adherent;
use App\Entity\CategoryAdherent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamController extends AbstractController
{
    /**
     * Liste d'adherents par équipe
     * @Route("/team/{id}/adherent", name="team_adherent")
     */
    public function index($id)
    {
        $repo = $this->getDoctrine()->getRepository(Team::class);
        $team = $repo->find($id);
        $team1 = $repo->findAll();
        $repo1 = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo1->findAll();
      
        $repo2 = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo2->findBy([],['lastName' => 'ASC']);
        return $this->render('team/index.html.twig', [
            'team' => $team,
            'team1' =>$team1,
            'catadherent' => $catadherent,
            'adherent' => $adherent
           
        ]);
    }
}
