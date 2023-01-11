<?php
namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Adherent;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\DateCommandes;
use App\Form\DateCommandesType;
use App\Form\CommandeclientType;
use App\Repository\CommandeRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminCommandeController extends AbstractController
{
    /**
     * Permet d'afficher toutes les produits distribués et commandés
     * @IsGranted("ROLE_ADMIN")
     * @Route("/commande", name="commande")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();
        $repodc =$this->getDoctrine()->getRepository(DateCommandes::class);
        $datecommandes= $repodc->find(1);

        return $this->render('admin/commande/index.html.twig', [
            'commande'      => $commande,
            'datecommandes' => $datecommandes

        ]);
    }

    /**
     * Permet d'afficher toutes les commandes
     * @IsGranted("ROLE_ADMIN")
     * @Route("/commande-en-cours", name="commande-en-cours")
     */
    public function commandes()
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();

        return $this->render('admin/commande/commandes.html.twig', [
            'commande' => $commande

        ]);
    }

    /**
     * Permet d'afficher tous les produits en commande à commander
     * @IsGranted("ROLE_ADMIN")
     * @Route("/a-commande", name="a-commande")
     */
    public function Acommande(ObjectManager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();
    foreach($commande as $c){
       $produit= $c->getproduit()->getId();
       $dateattribution = $c->getdateattribution();
       $code = $c->getproduit()->getcode();
       $title = $c->getproduit()->getTitle();
      
       if ($dateattribution == null) {
          
     
       }
      
      
      
      if ($dateattribution == null) {
        $commandes[]= $title.' | '.'code barre: '.$code.' | '.' Quantité manquante: '.$repo->Essai($produit); 
    }
    }
   
       //$commandes = $manager->createQuery('SELECT c, p, sum(c.qte) as cumul  FROM \App\Entity\Commande c INNER JOIN \App\Entity\Produit p WITH  c.dateattribution  IS NULL  GROUP BY p.id')->getScalarResult();
      // $commandes = $manager->createQuery('SELECT p,c, sum(c.qte) as cumul FROM \App\Entity\Produit p INNER JOIN \App\Entity\Commande c WITH c.dateattribution IS NULL GROUP BY p.id')->getScalarResult();

      //$commandes = $manager->createQuery('SELECT adherentId,produitId, SUM(qte) as TOTAL_QTE FROM App\Entity\Commande GROUP BY adherentId, produitId')->getResult();

//$out = array();

/*foreach($commandes as $C){
 $out[$C['adherentId']][$C['produitId']] = $C['TOTAL_QTE'];

}*/
//var_dump($out);
    
        return $this->render('admin/commande/a-commandes.html.twig', [
        'commande' => $commande,
           'commandes' => $commandes
           //'commandes' => $out

        ]);
        
    }

     /**
     * Permet de voir tous adherents ayant une commande
     * @IsGranted("ROLE_ADMIN")
     * @Route("/commande-par-adherent", name="commande-par-adherent")
     */
    public function commandeForAdherent(ObjectManager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->findAll();
    
        return $this->render('admin/commande/adherent_for_commande.html.twig', [
        'commande' => $commande   

        ]);
        
    }

     /**
     * Permet de créer une commande pour un client boutique
     * 
     * @Route("commande-client/{id}/new", name="commande_client")
     * @param ObjectManager $manager
     * @param AdherentRepository $repo
     * 
     * @return Response
     */
    public function client($id,Request $request, ObjectManager $manager,Adherent $adherent)
    {
        
        $commande = new Commande();
        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->find($id);
      
        //$commande->setDateattribution(new \DateTime('now'));
        $commande->setDatecommande(new \DateTime('now'));
    
    $formclient = $this->createForm(CommandeclientType::class, $commande);
        $formclient->handleRequest($request);

        if ($formclient->isSubmitted() && $formclient->isValid() && $commande->getQte()!= NULL) {
            //$manager =$this->getDoctrine()->getManager();
//debut modif
/*Recupere l'Id du produit selectionné*/
$p = $formclient['produit']->getData()->getId();
/*recupere le produit et lui ajoute l'Id du produit selectionné */
$repo1 = $this->getDoctrine()->getRepository(Produit::class);
$produit = $repo1->find($p);
/*Recupere la quantité du produit attribué a l'adherent */
$stockmoins = $formclient['qte']->getData();


/*mis a jour de la quantité du stock initial */
if ($stockmoins <= $produit->getQteinit()) {
    $produit->setQteinit($produit->getQteinit() - $stockmoins);


    /*Attribue l'id de l'adherent a la commande*/
   

//fin modif




            $commande->setAdherent($adherent);
            $manager->persist($commande);
            $manager->flush();
            $this->AddFlash(
                'success',
                "Le produit a bien été enregistré  !"
            );
            return $this->redirectToRoute('adherent_show', [
                'id' => $adherent->getId(),
            ]);


            //debut modif
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
            //fin modif
         
        
        return $this->render('admin/commande/client_for_commande.html.twig', [
            'formclient' => $formclient->createView()  
    
            ]);
    }

/**
     * Permet de valider une commande client
     * 
     * @Route("commande/{id}/validate", name="admin/commande_client_validate")
     *
     * @param Commande $commande
     * @param ObjectManager $manager
     * @return Response
     */
    public function validate(Commande $commande,Request $request, ObjectManager $manager)
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
     * Permet de modifier les dates de début et de fin des commandes dans les fiches adhérents
     * 
     * @Route("commande/date_commande/{id}/edit", name="admin/date_commande_edit")
     *
     */
    public function edit(DateCommandes $dateCommandes, Request $request,ObjectManager $manager) {
        $form = $this->createForm(DateCommandesType::class, $dateCommandes);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($dateCommandes);
            $manager->flush();
            $this->addFlash(
                'success',
                "Les dates ont bien étés modifiées !"
            );
            return $this->redirectToRoute("dashboard");
        }
        return $this->render('admin/date_commandes/edit.html.twig',[
            'dateCommandes' => $dateCommandes,
            'form' => $form->createView()
    ]);

    }
    

}
