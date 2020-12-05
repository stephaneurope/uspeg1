<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Adherent;
use App\Form\ConvocationType;
use App\Entity\CategoryAdherent;
use App\Form\AdherentContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamController extends AbstractController
{
    /**
     * Liste d'adherents par équipe
     * @Route("/team/{id}/adherent", name="team_adherent")
     */
    public function index($id,Request $request,MailerInterface $mailer)
    {
        $repo = $this->getDoctrine()->getRepository(Team::class);
        $team = $repo->find($id);
        $team1 = $repo->findAll();
        $repo1 = $this->getDoctrine()->getRepository(CategoryAdherent::class);
        $catadherent = $repo1->findAll();
        $repo2 = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo2->findBy([],['lastName' => 'ASC']);
        
      
  
    
           /***formulaire de contact*******/
           $formcontact = $this->createForm(ConvocationType::class);
           $contact = $formcontact->handleRequest($request);
           if($formcontact->isSubmitted() && $formcontact->isValid()){
            
            foreach ($contact->get('emailTo')->getData() as $c) {
                if($c->getEmail() != NULL){
                $emails[]= $c->getEmail(); // Ou autre selon la fonction de ta class Adhérent
     
    }
}
   // dump($emails);exit;
             if(isset($emails)){
               $email = (new TemplatedEmail())
               ->from($contact->get('email')->getData())
               ->to(...$emails)
               ->subject('contact')
               ->htmlTemplate('emails/convocation_match.html.twig')
               ->context([
                  'catadherent' =>$catadherent,
                  'mail' => $contact->get('email')->getData(),
                  'mailTo'=>$contact->get('emailTo')->getData(),
                  'team'=> $team->getName(),
                  'convocation_date'=>$contact->get('convocation_date')->getData(),
                  'club_adverse'=>$contact->get('club_adverse')->getData(),
                  'rendez_vous_date'=>$contact->get('rendez_vous_date')->getData(),
                  'lieu'=>$contact->get('lieu')->getData(),
                  'match_date'=>$contact->get('match_date')->getData(),
                  'stade'=>$contact->get('stade')->getData(),

               ]);
               $mailer->send($email);
               $this->AddFlash(
                   'success',
                   "Votre email a bien été envoyé !"
               );
               //return $this->redirectToRoute('adherent_show',['id' => $adherent->getId()]);
              }
              else{
                $this->AddFlash(
                    'danger',
                    "Votre email n'a pas été envoyé car aucun mail n'a été sélectionné !"
                );
              }
            }
           /**************************************************************/
      
      
        return $this->render('team/index.html.twig', [
            'team' => $team,
            'team1' =>$team1,
            'catadherent' => $catadherent,
            'adherent' => $adherent,
            'formcontact' =>$formcontact->createView()
           
        ]);
    }
}
