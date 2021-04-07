<?php

namespace App\Controller;

use App\Entity\Team;

use App\Entity\Amount;
use App\Entity\Produit;
use App\Entity\Adherent;
use App\Entity\Commande;
use App\Form\AmountType;
use App\Form\AdherentType;
use App\Form\CommandeType;
use App\Entity\PropertySearch;
use App\Form\AmountCreateType;
use App\Entity\CategoryAdherent;
use App\Form\AdherentContactType;
use App\Form\PropertySearchType;
use App\Service\PaginationService;
use App\Repository\AdherentRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryAdherentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * @IsGranted("ROLE_USER")
 */
class AdherentController extends AbstractController
{
    /**
     * Permet d'afficher tous les adhérents
     * 
     * @Route("/adherent/{page<\d+>?1}", name="adherent")
     * 
     */
    public function index(CategoryAdherentRepository $repo, $page, PaginationService $pagination,Request $request)
    {
     $propertySearch = new PropertySearch();
      $form = $this->createForm(PropertySearchType::class,$propertySearch);
      $form->handleRequest($request);
     //initialement le tableau des articles est vide, 
     //c.a.d on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher
      $adherent= [];
      
     if($form->isSubmitted() && $form->isValid()) {
     //on récupère le nom d'article tapé dans le formulaire
      $nom = $propertySearch->getNom();   
      if ($nom!="") 
        //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
        $adherent = $this->getDoctrine()->getRepository(Adherent::class)->findBy(['lastName' => $nom] );
    else
    $this->addFlash(
        'warning',
        "Désolé, le champ est vide !"
    );
  
    } 
        
       
        $pagination->setEntityClass(Adherent::class) 
        ->setPage($page);   
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo->findBy([], ['list' => 'ASC']);
        $repo = $this->getDoctrine()->getRepository(Team::class);
        $team1 = $repo->findAll();
    
        return $this->render('adherent/index.html.twig', [
            'form' =>$form->createView(),
            'adherent'=>$adherent,
            'pagination' => $pagination,
            'catadherent' => $catadherent,
            'team1' => $team1
        ]);
    }

    
    /**
     * Permet d'afficher un adherent
     * 
     * @Route("/adherent/{id}/show", name="adherent_show")
     * 
     * 
     * @param ObjectManager $manager
     * @param AdherentRepository $repo
     * 
     * @return Response
     */
    public function show($id,Request $request, ObjectManager $manager, MailerInterface $mailer)
    {
        
        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->find($id);
        $repo1 = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $cat = $repo1->findAll();
        
        /***formulaire de contact*******/
        $formcontact = $this->createForm(AdherentContactType::class);
        $contact = $formcontact->handleRequest($request);
        if($formcontact->isSubmitted() && $formcontact->isValid()){
            $email = (new TemplatedEmail())
            //->from($contact->get('email')->getData())
            ->from('contact@uspeg-gestion.com')
            ->to($adherent->getEmail())
            ->subject('contact')
            ->htmlTemplate('emails/contact_adherent.html.twig')
            ->context([
                'adherent' =>$adherent,
                'mail' => ('contact@uspeg-gestion.com'),
                'message'=> $contact->get('message')->getData()
            ]);
            $mailer->send($email);
            $this->AddFlash(
                'success',
                "Votre email a bien été envoyé !"
            );
            return $this->redirectToRoute('adherent_show',['id' => $adherent->getId()]);
        }
        /**************************************************************/
        /************commande directement dans la page de l'adherent**************/
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
        
   
       /*************************************************************************/
       /*******************Creation de la cotisation directement*****************/
      
       $a=$adherent->getAmounts()->toarray();
       if ($a == null) {
        $amount = new Amount();
        $form1 = $this->createForm(AmountCreateType::class, $amount);
        $form1->handleRequest($request);
 
     
        if ($form1->isSubmitted() && $form1->isValid()) {

            $amount->setAdherent($adherent);

            $manager->persist($amount);
            $manager->flush();

            $this->addFlash(
                'success',
                "La cotisation a bien été enregistrée !"
            );
            return $this->redirectToRoute('adherent_show', [
                'id' => $adherent->getId() ]);
            
        } 
        
     /*************************************************************************/
       }else{
 /*********************Permet de modifier les cotisations******************/
      $a=$adherent->getAmounts()->toarray();
      $id_amount=$a[0]->getId();
      $repo2 = $this->getDoctrine()->getRepository(Amount::class);
    
      $amount = $repo2->find($id_amount);

      foreach($cat as $cat) { 
        if ($cat->getTitle() == $adherent->getSubcategory()){

            $montantcot = $cat->getMontantcot();
          
             $reste = $montantcot - $amount->getAmountTotal();
             
        }
     }
	
 $form1 = $this->createForm(AmountType::class, $amount);
 
 $form1->handleRequest($request);
 $amount->setReste($montantcot - $reste);
 $amount_total = $form1['amount1']->getData() + $form1['amount2']->getData() + $form1['amount3']->getData() + $form1['amount4']->getData();
 $amount->setAmountTotal($amount_total);
 $restebasededonnee = $montantcot - $amount_total;
 $amount->setReste($restebasededonnee);
 if ($form1->isSubmitted() && $form1->isValid()) {
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
 
 /*************************************************************************/ 
  
        
       }
    if (empty($montantcot) and empty($reste)) {
        return $this->render('adherent/show.html.twig', [
            'adherent' => $adherent,
            'cat' => $cat,
            'commande' => $commande,
            'form' => $form->createView(),
            'form1' => $form1->createView(),    
            'amount' => $amount,
            'formcontact' => $formcontact->createView(),
            
            
        ]);
    }
        return $this->render('adherent/show.html.twig', [
            'adherent' => $adherent,
            'cat' => $cat,
            'commande' => $commande,
            'form' => $form->createView(),
            'form1' => $form1->createView(),    
            'amount' => $amount,
            'formcontact' => $formcontact->createView(),
            'montantcot' => $montantcot,
            'reste' => $reste,
            
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
        $adherent->setRecord(new \DateTime('now'));
     
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

}