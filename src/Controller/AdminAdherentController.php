<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Amount;
use App\Entity\Adherent;
use App\Form\AdherentModifType;
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
        $repo2 = $this->getDoctrine()->getRepository(Team::class);
        $team1 = $repo2->findAll();

        

        return $this->render('/admin/adherent/index.html.twig', [
            'pagination' => $pagination,
            'catadherent'  => $catadherent,
            'team1' => $team1,
            
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
        $repo2 = $this->getDoctrine()->getRepository(Team::class);
        $team1 = $repo2->findAll();



        return $this->render('admin/category_adherent/index.html.twig', [
            'adherent' => $adherent,
            'catadherent' => $catadherent,
            'categoryadherent' => $categoryadherent,
            'team1' => $team1
        ]);
    }

     /**
     * Permet de modifier un adhérent
     *
     * @Route("admin/adherent/{id}/edit", name="admin/adherent_modif")
     * 
     * @return Response
     */
    public function modif(Adherent $adherent, Request $request, ObjectManager $manager,$id)
    {
  

        $form = $this->createForm(AdherentModifType::class, $adherent);

        $form->handleRequest($request);
        $repo = $this->getDoctrine()->getRepository(CategoryAdherent::class);;
        $cat = $repo->findAll();
       
        foreach($cat as $listecat)
        {
            $liste = $listecat->getTitle(); 
            $catid = $listecat->getId();  
     //var_dump(array($catid));
     
  
if (in_array($adherent->getSubCategory(), array($liste))) {
   
   $a = $catid;
//var_dump($a);

}
        }
    
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($adherent);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'adherent {$adherent->getLastName()} {$adherent->getFirstName()} a bien été modifié !"
            );
     if(isset ($a)){
            return $this->redirectToRoute("category_adherent",['id' => $a]);}else
            {
                return $this->redirectToRoute("adherent");  
            }
      
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
/*essai*/
        $this->addFlash(
            'success',
            "L'adhérent à bien été supprimé !"
        );

        return $this->redirectToRoute("adherent");
    }


}
