<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Adherent;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class CommandeController extends AbstractController
{

    /**
     * Permet de créer une commande
     * 
     * @Route("/commande/adherent/{id}/new/", name="commande_create")
     */
    public function create(Request $request, ObjectManager $manager, $id)
    {

        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->find($id);

        $commande = new Commande();
        

        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            
            /*Recupere l'Id du produit selectionné*/
            $p = $form['produit']->getData()->getId();
            /*recupere le produit et lui ajoute l'Id du produit selectionné */
            $repo1 = $this->getDoctrine()->getRepository(Produit::class);
            $produit = $repo1->find($p);
            /*Recupere la quantité du produit attribué a l'adherent */
            $stockmoins = $form['qte']->getData();


            /*mis a jour de la quantité du stock initial */
            if ($stockmoins <= $produit->getQteinit()) {
                $produit->setQteinit($produit->getQteinit() - $stockmoins);
            

                /*Attribue l'id de l'adherent a la commande*/
                $commande->setAdherent($adherent);

                $commande->setDateattribution(new \DateTime('now'));
                $manager->persist($commande);

                $manager->flush();

                $this->AddFlash(
                    'success',
                    "Le produit a bien été enregistré  !"
                );
                return $this->redirectToRoute('adherent_show', [
                    'id' => $adherent->getId(),
                ]);
            } else
                $commande->setAdherent($adherent);
                $commande->setDatecommande(new \DateTime('now'));

            $manager->persist($commande);

            $manager->flush();

            $this->AddFlash(
                'danger',
                "Vous n'avez pas assez de produit en stock , le produit est passé en commande !"
            );
            return $this->redirectToRoute('adherent_show', [
                'id' => $adherent->getId(),
            ]);
        }

        return $this->render("commande/create.html.twig", [
            'adherent' => $adherent,
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de valider une commande
     * 
     * @Route("/commande/adherent/{id}/validate/", name="commande_validate")
     */
    public function validate(Commande $commande,Request $request,ObjectManager $manager)
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
             /*Recupere l'Id du produit selectionné*/
             $p = $form['produit']->getData()->getId();
             /*recupere le produit et lui ajoute l'Id du produit selectionné */
             $repo1 = $this->getDoctrine()->getRepository(Produit::class);
             $produit = $repo1->find($p);
             /*Recupere la quantité du produit attribué a l'adherent */
             $stockmoins = $form['qte']->getData();
 
 
             /*mis a jour de la quantité du stock initial */
             if ($stockmoins <= $produit->getQteinit()) {
                 $produit->setQteinit($produit->getQteinit() - $stockmoins);
             
 
                 $commande->setDateattribution(new \DateTime('now'));
                 $manager->persist($commande);
 
                 $manager->flush();
 
                 $this->AddFlash(
                     'success',
                     "Le produit a bien été enregistré  !"
                 );
                 return $this->redirectToRoute('adherent_show', [
                     'id' => $commande->getAdherent()->getId(),
                 ]);
             } else
                 
 
             $this->AddFlash(
                 'danger',
                 "Vous n'avez pas assez de produit en stock , le produit est toujours en commande !"
             );
            return $this->redirectToRoute('adherent_show', [
                'id' => $commande->getAdherent()->getId(),
            ]);
        }
        

        return $this->render("commande/validate.html.twig", [
           'commande' => $commande,
           'form' => $form->createView(),
        ]);
    }





    /**
     * Permet d'afficher un produit d'une commande lié a un adhérent
     * 
     * @Route("/commande/produit/{id}/show", name="commande_show")
     * 
     * @param ProduitRepository $repo
     * @param ObjectManager $manager
     * 
     * @return void 
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->find($id);

        return $this->render('commande/show.html.twig', [
            'commande' => $commande

        ]);
    }

    /**
     * Permet d'afficher la liste de commande d'un adherent
     * 
     * @Route("/commande/produit/{id}/edit", name="commande_produit")
     * 
     * @param CommandeRepository $repo
     * @param AdherentRepository $repo2
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function edit($id)
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $repo2 = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo2->find($id);
        $commande = $repo->findAll();
        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'adherent' => $adherent
        ]);
    }

    /**
     * Permet de suprimer une commande
     * 
     * @Route("/commande/produit/{id}/delete", name="commande_delete")
     * 
     * @param Commande $commande
     * @param ObjectManager $manager
     * @return Response
     */
    public function commande_delete(Commande $commande, ObjectManager $manager)
    {
        $manager->remove($commande);
        $manager->flush();

        $this->AddFlash(
            'success',
            "L'équipement a bien été supprimé !"
        );

       // return $this->redirectToRoute("commande");
        return $this->redirectToRoute(
            "adherent_show",
            array(
                'id' => $commande->getAdherent()->getId()
            )
        );
    }
}
