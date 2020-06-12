<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Entity\Adherent;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTeamController extends AbstractController
{

    /**
     * dashboard des équipes
     * 
     *
     * @Route("/admin/team", name="admin_team")
     */
    public function dashboard()
    {
        $repo = $this->getDoctrine()->getRepository(Team::class);
        $team = $repo->findAll();
        
     
        return $this->render('admin/team/dashboard.html.twig', [
            'team' => $team
        ]);
    }

    /**
     * Permet d'ajouter une équipe
     * 
     * @Route("/admin/team/new", name="admin_team_create")
     * @param Team $team
     * 
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $team = New Team();

        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($team);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'équipe a bien été ajouter !"
            );

           return $this->redirectToRoute("admin_team");
        }

        return $this->render('admin/team/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * Permet de modifier une équipe
     * 
     * @Route("/admin/team/{id}/edit", name="admin_team_edit")
     * 
     * @return Response
     */
    public function edit(Team $team,Request $request,ObjectManager $manager)
    {

        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($team);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'équipe' a bien été modifié !"
            );
            return $this->redirectToRoute("admin_team");
        }
      
        return $this->render('admin/team/edit.html.twig', [
            'team' => $team,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de suprimer une catégorie
     * 
     * @Route("admin/team/{id}/delete", name="admin_team_delete")
     *
     * @param Team $team
     * @param ObjectManager $manager
     * @param Adherent $adherent 
     * 
     * @return Response
     */
    public function delete(Team $team,ObjectManager $manager)
    {
      
        $team->removeAdherents();
       
        $manager->remove($team);
    

        $manager->flush();
        $this->addFlash(
            'success',
            "L'équipe' a bien été supprimé !");

        return $this->redirectToRoute("admin_team");
    }

}
