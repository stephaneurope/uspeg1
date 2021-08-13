<?php

namespace App\Controller;


use App\Entity\Debt;
use App\Entity\Amount;
use App\Entity\Adherent;
use App\Form\AmountType;
use App\Form\AmountCreateType;
use App\Entity\CategoryAdherent;
use App\Entity\PropertySearchNameCheque;
use App\Entity\PropertySearchNameCheque2;
use App\Entity\PropertySearchNameCheque3;
use App\Entity\PropertySearchNameCheque4;
use App\Entity\PropertySearchNum;
use App\Entity\PropertySearchNum2;
use App\Entity\PropertySearchNum3;
use App\Entity\PropertySearchNum4;
use App\Form\PropertySearchNameCheque2Type;
use App\Form\PropertySearchNameCheque3Type;
use App\Form\PropertySearchNameCheque4Type;
use App\Form\PropertySearchNameChequeType;
use App\Form\PropertySearchNumType;
use App\Form\PropertySearchNum2Type;
use App\Form\PropertySearchNum3Type;
use App\Form\PropertySearchNum4Type;
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

        return $this->redirectToRoute(
            "adherent_show",
            [
                'id' => $amount->getAdherent()->getId()
            ]
        );
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

     /**
      * Permet de rechercher un chèque par son numéro
      * @Route("amount/searchcheque", name="searchcheque")
      */
      public function search_cheque(Request $request)
     {
//recherche par numero//////////////////
       $search = new PropertySearchNum();
       $search2 = new PropertySearchNum2();
       $search3 = new PropertySearchNum3();
       $search4 = new PropertySearchNum4();
       $form = $this->createForm(PropertySearchNumType::class,$search);
       $form->handleRequest($request);
       $form2 = $this->createForm(PropertySearchNum2Type::class,$search2);
       $form2->handleRequest($request);
       $form3 = $this->createForm(PropertySearchNum3Type::class,$search3);
       $form3->handleRequest($request);
       $form4 = $this->createForm(PropertySearchNum4Type::class,$search4);
       $form4->handleRequest($request);

//initialement le tableau des articles est vide, 
     //c.a.d on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher
     $amount= [];
     $amount2= [];
     $amount3= [];
     $amount4= [];

     if($form->isSubmitted() && $form->isValid()) {
     //on récupère le nom d'article tapé dans le formulaire
      $numcheque = $search->getnumcheque(); 
     
      if ($numcheque!="") {
        //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
        $amount = $this->getDoctrine()->getRepository(Amount::class)->findBy(['numcheque' => $numcheque] );
        
      }
      
      else{
    $this->addFlash(
        'warning',
       "Le champ est vide"
    );
      
}
  

    }
        //amount 2
        if ($form2->isSubmitted() && $form2->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $numcheque2 = $search2->getNumcheque2();

            if ($numcheque2 !="") {
                //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
                $amount2 = $this->getDoctrine()->getRepository(Amount::class)->findBy(['numcheque2' => $numcheque2]);
            } else {
                $this->addFlash(
                    'warning',
                    "Le champ est vide !"
                );
            }
        }
         //amount 3
         if ($form3->isSubmitted() && $form3->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $numcheque3 = $search3->getNumcheque3();

            if ($numcheque3 !="") {
                //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
                $amount3 = $this->getDoctrine()->getRepository(Amount::class)->findBy(['numcheque3' => $numcheque3]);
            } else {
                $this->addFlash(
                    'warning',
                    "Le champ est vide !"
                );
            }
        }
        //amount 4
        if ($form4->isSubmitted() && $form4->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $numcheque4 = $search4->getNumcheque4();

            if ($numcheque4 !="") {
                //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
                $amount4 = $this->getDoctrine()->getRepository(Amount::class)->findBy(['numcheque4' => $numcheque4]);
            } else {
                $this->addFlash(
                    'warning',
                    "Le champ est vide !"
                );
            }
        }

        //Fin de recherche par numero//////////////////

        //recherche par nom//////////////////
       $searchName  = new PropertySearchNameCheque();
       $searchName2 = new PropertySearchNameCheque2();
       $searchName3 = new PropertySearchNameCheque3();
       $searchName4 = new PropertySearchNameCheque4();
       $formName = $this->createForm(PropertySearchNameChequeType::class,$searchName);
       $formName->handleRequest($request);
       $formName2 = $this->createForm(PropertySearchNameCheque2Type::class,$searchName2);
       $formName2->handleRequest($request);
       $formName3 = $this->createForm(PropertySearchNameCheque3Type::class,$searchName3);
       $formName3->handleRequest($request);
       $formName4 = $this->createForm(PropertySearchNameCheque4Type::class,$searchName4);
       $formName4->handleRequest($request);

       //initialement le tableau des articles est vide, 
     //c.a.d on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher
     $amountName= [];
     $amountName2= [];
     $amountName3= [];
     $amountName4= [];

     if($formName->isSubmitted() && $formName->isValid()) {
        //on récupère le nom d'article tapé dans le formulaire
         $name = $searchName->getName(); 
        
         if ($name!="") {
           //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
           $amountName = $this->getDoctrine()->getRepository(Amount::class)->findBy(['name' => $name] );
           
         }
         
         else{
       $this->addFlash(
           'warning',
          "Le champ est vide"
       );
         
   }
       
       }
       //AmountName2//
       if($formName2->isSubmitted() && $formName2->isValid()) {
        //on récupère le nom d'article tapé dans le formulaire
         $name2 = $searchName2->getName2(); 
        
         if ($name2!="") {
           //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
           $amountName2 = $this->getDoctrine()->getRepository(Amount::class)->findBy(['name2' => $name2] );
           
         }
         
         else{
       $this->addFlash(
           'warning',
          "Le champ est vide"
       );
         
   }
       
       }

       //AmountName3//
       if($formName3->isSubmitted() && $formName3->isValid()) {
        //on récupère le nom d'article tapé dans le formulaire
         $name3 = $searchName3->getName3(); 
        
         if ($name3!="") {
           //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
           $amountName3 = $this->getDoctrine()->getRepository(Amount::class)->findBy(['name3' => $name3] );
           
         }
         
         else{
       $this->addFlash(
           'warning',
          "Le champ est vide"
       );
         
   }
       
       }

       //AmountName4//
       if($formName4->isSubmitted() && $formName4->isValid()) {
        //on récupère le nom d'article tapé dans le formulaire
         $name4 = $searchName4->getName4(); 
        
         if ($name4!="") {
           //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
           $amountName4 = $this->getDoctrine()->getRepository(Amount::class)->findBy(['name4' => $name4] );
           
         }
         
         else{
       $this->addFlash(
           'warning',
          "Le champ est vide"
       );
         
   }
       
       }

        //Fin de recherche par nom//////////////////

            return $this->render('amount/recherche_cheque.html.twig', [
                'form' => $form->createView(),
                'form2' => $form2->createView(),
                'form3' => $form3->createView(),
                'form4' => $form4->createView(),
                'formName' => $formName->createView(),
                'formName2' => $formName2->createView(),
                'formName3' => $formName3->createView(),
                'formName4' => $formName4->createView(),
                'amount' => $amount,
                'amount2' => $amount2,
                'amount3' => $amount3,
                'amount4' => $amount4,
                'amountName' => $amountName,
                'amountName2' => $amountName2,
                'amountName3' => $amountName3,
                'amountName4' => $amountName4,
            ]);
        
    }

}
