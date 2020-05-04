<?php

namespace App\Controller;

use App\Entity\Amount;
use App\Entity\Adherent;
use App\Form\AdherentType;
use App\Service\PaginationService;
use App\Repository\AdherentRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdherentController extends AbstractController
{
    /**
     * @Route("/adherent/{page<\d+>?1}", name="adherent")
     */
    public function index(AdherentRepository $repo, $page, PaginationService $pagination)
    {
        $pagination->setEntityClass(Adherent::class)
            ->setPage($page);

        return $this->render('adherent/adherent.html.twig', [
            'pagination' => $pagination
        ]);
    }
    /**
     * Permet d'editer un adherent
     * 
     * @Route("/adherent/{id}/edit", name="adherent_edit")
     *
     * @param AdherentRepository $repo
     * @param ObjectManager $manager
     * @return void
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->find($id);


        return $this->render('adherent/edit.html.twig', [
            'adherent' => $adherent

        ]);
    }

    /**
     * Permet d'ajouter un adherent
     * 
     * @Route("adherent/new", name="adherent_create")
     *
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $adherent = new adherent();

        $form = $this->createForm(AdherentType::class, $adherent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$manager =$this->getDoctrine()->getManager();

            $manager->persist($adherent);
            $manager->flush();
            $this->addFlash(
                'success',
                "<strong>{$adherent->getLastName()} {$adherent->getFirstName()} </strong> a bien été ajouter à la liste d'adhérent !"
            );

            return $this->redirectToRoute('adherent');
        }

        return $this->render('adherent/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de suprimer un adherent
     * 
     * @Route("adherent/{id}/delete", name="adherent_delete")
     *
     * @param Adherent $adherent
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Adherent $adherent, ObjectManager $manager)
    {
        $manager->remove($adherent);
        $manager->flush();

        return $this->redirectToRoute("adherent");
    }

    /**
     * Permet de modifier un adhérent
     *
     * @Route("adherent/{id}/modif", name="adherent_modif")
     * 
     * @return Response
     */
    public function modif(Adherent $adherent, Request $request, ObjectManager $manager)
    {

        //$repo = $this->getDoctrine()->getRepository(Adherent::class);
        //$adherent = $repo->find($id);
        $form = $this->createForm(AdherentType::class, $adherent);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($adherent);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'adherent {$adherent->getLastName()} {$adherent->getFirstName()} a bien été modifié !"
            );
        }


        return $this->render('adherent/modif.html.twig', [
            'adherent' => $adherent,
            'form' => $form->createView()
        ]);
    }
}
