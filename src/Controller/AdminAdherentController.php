<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Form\AdherentType;
use App\Entity\CategoryAdherent;
use App\Service\PaginationService;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryAdherentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminAdherentController extends AbstractController
{
    /**
     * Permet d'afficher tous les adhérents
     * 
     * @Route("admin/adherent/{page<\d+>?1}", name="admin/adherent")
     */
    public function index(CategoryAdherentRepository $repo,$page, PaginationService $pagination)
    {
        
        $pagination->setEntityClass(Adherent::class)
            ->setPage($page);

            $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo->findAll();

        return $this->render('/admin/adherent/index.html.twig', [
            'pagination' => $pagination,
            'catadherent'  => $catadherent
        ]);
    }

    /**
     * Liste des adhérents par catégorie
     * 
     * 
     * @Route("/category/{id}/adherent", name="admin/category_adherent")
     */
    public function showcat($id)
    {
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $categoryadherent = $repo->find($id);
        $catadherent = $repo->findAll();

        $repo1 = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo1->findAll();



        return $this->render('admin/category_adherent/index.html.twig', [
            'adherent' => $adherent,
            'catadherent' => $catadherent,
            'categoryadherent' => $categoryadherent
        ]);
    }

     /**
     * Permet de modifier un adhérent
     *
     * @Route("admin/adherent/{id}/edit", name="admin/adherent_modif")
     * 
     * @return Response
     */
    public function modif(Adherent $adherent, Request $request, ObjectManager $manager)
    {

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


        return $this->render('admin/adherent/edit.html.twig', [
            'adherent' => $adherent,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de suprimer un adherent
     * 
     * @Route("adherent/{id}/delete", name="admin/adherent_delete")
     *
     * @param Adherent $adherent
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Adherent $adherent, ObjectManager $manager)
    {
        $manager->remove($adherent);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'adhérent à bien été supprimé !"
        );

        return $this->redirectToRoute("adherent");
    }


}
