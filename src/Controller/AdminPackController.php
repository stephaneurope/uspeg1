<?php

namespace App\Controller;

use App\Entity\Pack;
use App\Form\PackType;
use App\Entity\Categoryproduit;
use App\Entity\CategoryAdherent;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminPackController extends AbstractController
{
    /**
     * Permet d'afficher la liste de pack
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/pack", name="admin_pack")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Pack::class);
        $pack = $repo->findAll();
        
     
        return $this->render('admin/pack/index.html.twig', [
            'pack' => $pack
        ]);
    }

    

    /**
     * Permet de modifier un pack
     * 
     * @Route("/admin/pack/{id}/edit", name="pack_edit")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function edit(Pack $pack,Request $request,ObjectManager $manager)
    {

        $form = $this->createForm(PackType::class, $pack);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($pack);
            $manager->flush();
            $this->addFlash(
                'success',
                "Le Pack a bien été modifié !"
            );
            return $this->redirectToRoute("admin_pack");
        }
      
        return $this->render('admin/pack/edit.html.twig', [
            'pack' => $pack,
            'form' => $form->createView()
        ]);
    }
    /**
     * Permet de suprimer un pack
     * @IsGranted("ROLE_ADMIN")
     * @Route("admin/pack/{id}/delete", name="pack_delete")
     *
     * @param Pack $pack
     * @param ObjectManager $manager
     * @param CategoryAdherent $categoryadherent
     * 
     * @return Response
     */
    public function delete(Pack $pack,ObjectManager $manager)
    {
        $pack->removeCategoryAdherents();
        $manager->remove($pack);
    

        $manager->flush();
        $this->addFlash(
            'success',
            "Le pack a bien été supprimé !");

        return $this->redirectToRoute("admin_pack");
    }

    /**
     * Permet d'ajouter un pack
     * 
     * @Route("admin/pack/new", name="pack_create")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $produit = new pack();

        $form = $this->createForm(PackType::class, $produit);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($produit);
            $manager->flush();
            $this->addFlash(
                'success',
                "Le pack  a bien été ajouter à la liste des produits !"
            );

            return $this->redirectToRoute("admin_pack");
        }

        return $this->render('admin/pack/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
