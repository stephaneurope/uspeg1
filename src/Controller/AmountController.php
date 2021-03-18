<?php

namespace App\Controller;


use App\Entity\Debt;
use App\Entity\Amount;
use App\Entity\Adherent;
use App\Form\AmountType;
use App\Form\AmountCreateType;
use App\Entity\CategoryAdherent;
use App\Repository\AdherentRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




/**
 * @IsGranted("ROLE_USER")
 */
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
        return $this->render(('amount/index.html.twig'),
            [
                'amount' => $amount
            ]
        );
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

            return $this->redirectToRoute(
                "adherent_show",
                [
                    'id' => $amount->getAdherent()->getId()
                ]
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
                "adherent_show",
                array(
                    'id' => $amount->getAdherent()->getId()
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

    /**
     * Vide la table debt et Rempli l'entité debt de la BDD de la liste des adhérents qui n'ont pas payé leur cotisation
     * 
     * 
     * @Route("amount/copy/cotisation", name="copy_cotisation")
     * 
     * 
     *
     * @param ObjectManager $manager
     * @return Response
     */
    public function copy(ObjectManager $manager)
    {
        $connection = $this->getDoctrine()->getConnection();
        $platform   = $connection->getDatabasePlatform(); 
        $connection->executeUpdate($platform->getTruncateTableSQL('debt', true /* whether to cascade */));
        
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherents = $repo->findAll();
        $repo1 = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo1->findAll();
       

        foreach ($adherent as $ad) {

            foreach ($ad->getAmounts() as $key => $a) {
                
                $total = ($a->getAmount1() + $a->getAmount2() + $a->getAmount3() + $a->getAmount4());
                
               
                foreach ($catadherents as $cat) {
                    $montant_total = $cat->getMontantcot();
                    $reste_du = $montant_total - $total;
                 
               
                    if (isset($a) and $cat->getTitle() === $ad->getSubcategory() and $total < $montant_total) {
                       
                        $debt = new Debt();
                        $debt->setName($ad->getLastName());
                        $debt->setPrenom($ad->getFirstName());
                        $debt->setCategory($ad->getSubCategory());
                        $debt->setMail($ad->getEmail());
                        $debt->setTel($ad->getMobilePhone());
                        $debt->setAmount($reste_du);
                        $manager->persist($debt);
                        $manager->flush();

                    }
                 
                }
               
            }
        }
        
        $this->addFlash(
            'success',
            "La liste des adhérents qui n'ont pas totalement payé leur cotisation a bien été importé !"
        );
        return $this->redirectToRoute(
            "dashboard"
        );
    }

/**
     * Permet de suprimer toutes les cotisations
     * 
     * @Route("amount/delete", name="amount_delete")
     *
     * 
     */
    public function amountdelete()
    {
        $connection = $this->getDoctrine()->getConnection();
        $platform   = $connection->getDatabasePlatform(); 
        $connection->executeUpdate($platform->getTruncateTableSQL('amount', true /* whether to cascade */));

        $this->addFlash(
            'success',
            "Toutes les cotisations ont bien été supprimées !"
        );

        return $this->redirectToRoute("dashboard");
    }

     /**
     * Permet d'afficher la table debt
     * @Route("amount/default_payment", name="debt")
     */
     public function default_payment()
     {
      $repo = $this->getDoctrine()->getRepository(Debt::class);
      $debt = $repo->findAll();
      return $this->render('amount/debt.html.twig', [
      'debt' => $debt
      ]);
     }

}
