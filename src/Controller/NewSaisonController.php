<?php

namespace App\Controller;

use App\Entity\Debt;
use App\Entity\Adherent;
use App\Entity\CategoryAdherent;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class NewSaisonController extends AbstractController
{
    /**
     * permet de passer a la nouvelle saison
     * @Route("admin/new/NewSaison", name="new_saison")
     * 
     * @param ObjectManager $manager 
     * @return Response
     */
    public function index(ObjectManager $manager)
    {
        
 //Vide la table debt et Rempli l'entité debt de la BDD de la liste des adhérents qui n'ont pas payé leur cotisation
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

// Permet de suprimer toutes les cotisations
        $connection = $this->getDoctrine()->getConnection();
        $platform   = $connection->getDatabasePlatform(); 
        $connection->executeUpdate($platform->getTruncateTableSQL('amount', true /* whether to cascade */));

        // Permet de réinitialiser les catégories sauf la boutique
        $em = $this->getDoctrine()->getManager();
        $adherent = $em->getRepository('App:Adherent');
        $liste = $adherent->findBy(array());
        
        
        foreach($liste as $unadherent){
          
            $categoryadherent = $em->getRepository('App:CategoryAdherent');
        $ca = $categoryadherent->findBy(array());
        foreach($ca as $ca){
            if ($unadherent->getSubCategory() == $ca->getTitle()){
             
               $a = $ca->getOrdre() + 1;
               $cat = $categoryadherent->findBy(array('ordre' => $a));
                        
            }
            
            }
            foreach($cat as $cat){
                $ca2 = $cat->getTitle();

            $unadherent->setSubCategory($ca2);
           $em->flush();
            }
        }
//met l'essayage a 0
   
        $essayage = $em->getRepository('App:Essayage');
        $essayage = $essayage->findBy(array());
        foreach($essayage as $essayage){
           

        $essayage->setEssaie(0);
       $em->flush();
    }
            $this->addFlash(
                'success',
                "Bienvenue dans la nouvelle saison ! Votre passage à la nouvelle saison a bien fonctionné.N'oubliez pas de vérifier le point 5 de ce tableau de bord."
            );
    
            return $this->redirectToRoute("dash_new_season");
    }
    
    /**
     * Permet d'afficher le dashboard de la nouvelle saison'
     *
     * @Route("/admin/newSaison/dashboard", name="dash_new_season")
     * 
     */
    public function dash()
    {

        return $this->render('/new_saison/index.html.twig',[
           
    ]);
    }
   
}