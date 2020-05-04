<?php

namespace App\Controller;

use App\Entity\Amount;
use App\Form\AmountType;
use App\Form\AmountCreateType;
use App\Entity\Adherent;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AmountController extends AbstractController
{
    /**
     * Permet d'afficher toutes les cotisations de tous les adherents
     * @Route("/amount", name="amount")
     */
    // public function index()
    // {
    //  $repo = $this->getDoctrine()->getRepository(Amount::class);
    // $amount = $repo->findAll();
    //return $this->render('amount/index.html.twig', [
    //'amount' => $amount
    //]);
    //}

    /**
     * Permet d'afficher la cotisation d'un adherents
     * @Route("amount/{id}/edit", name="amount_edit")
     * 
     * @param AmountRepository $repo
     * @param ObjectManager $manager
     * @return void 
     */
    public function edit($id)
    {
        $repo = $this->getDoctrine()->getRepository(Amount::class);
        $amount = $repo->find($id);
        return $this->render('amount/index.html.twig', [
            'amount' => $amount
        ]);
    }

    /**
     * Permet de créer une cotisation
     *
     * @Route("/amount/{id}/new" , name="amount_create")
     * 
     * 
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager, $id)
    {

        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->find($id);

        $amount = new Amount();


        $form = $this->createForm(AmountCreateType::class, $amount);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $amount->setAdherent($adherent);

            $manager->persist($amount);
            $manager->flush();

            $this->addFlash(
                'success',
                "La cotisation a bien été enregistrée !"
            );
        }

        return $this->render('amount/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Permet de modifier une cotisation
     *
     * @Route("amount/{id}/modif", name="amount_modif")
     * 
     * @param Amount $amount
     * 
     * @return Response
     */
    public function modif(Amount $amount, Request $request, ObjectManager $manager)
    {


        $form = $this->createForm(AmountType::class, $amount);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($amount);
            $manager->flush();
            $this->addFlash(
                'success',
                "La cotisation a bien été modifiée !"
            );
            return $this->redirectToRoute(
                "amount_edit",
                array(
                    'id' => $amount->getId()
                )
            );
        }
        return $this->render('amount/amount_modif.html.twig', [
            'amount' => $amount,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de suprimer une cotisation
     * 
     * @Route("amount/{id}/delete", name="amount_delete")
     *
     * @param Amount $adherent
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Amount $amount, ObjectManager $manager)
    {
        $manager->remove($amount);
        $manager->flush();

        return $this->redirectToRoute("amount");
    }
}
