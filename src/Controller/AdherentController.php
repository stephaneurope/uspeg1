<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Adherent;
use App\Form\AdherentType;
use App\Entity\PropertySearch;
use App\Entity\CategoryAdherent;
use App\Form\PropertySearchType;
use App\Service\PaginationService;
use App\Repository\AdherentRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryAdherentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
         
        $pagination->setEntityClass(Adherent::class) 
        ->setPage($page);   
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo->findAll();
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
     * @param AdherentRepository $repo
     * @param ObjectManager $manager
     * @return void
     */
    public function show($id)
    {
        
        $repo = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo->find($id);
        $repo1 = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $cat = $repo1->findAll();
       

        return $this->render('adherent/show.html.twig', [
            'adherent' => $adherent,
            'cat' => $cat
              
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
