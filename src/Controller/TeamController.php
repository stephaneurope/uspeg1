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
        $catadherent = $repo1->findBy([], ['list' => 'ASC']);
        $repo2 = $this->getDoctrine()->getRepository(Adherent::class);
        $adherent = $repo2->findBy([],['lastName' => 'ASC']);
        
        
         if($team->getAdherents()!= null) {
        foreach ($team->getAdherents() as $c) {
            if($c->getEmail() != null){
                $mails[] = $c->getEmail();
            }
            
        }
    }
        if (isset($mails)) {
            $mails = array_combine($mails , $mails);
        }
       
      //var_dump($mails);exit();
  
    
           /***formulaire de contact*******/
           if (isset($mails)) {
           $formcontact = $this->createForm(ConvocationType::class,$mails,[
            'mails' => $mails,
        ]);
           
           $contact = $formcontact->handleRequest($request);
           if($formcontact->isSubmitted() && $formcontact->isValid()){

            
            
            foreach ($contact->get('emailTo')->getData() as $c) {
                if($c != NULL){
                $emails[]= $c;} // Ou autre selon la fonction de ta class Adhérent    
                else {
                $emails[]= null;}
                }
   // dump($emails);exit;
             if(isset($mails) and isset($emails)){
               $email = (new TemplatedEmail())
               //->from($contact->get('email')->getData())
               ->from('contact@uspeg-gestion.com')
               ->to(...$emails)
               ->subject('contact')
               ->htmlTemplate('emails/convocation_match.html.twig')
               ->context([
                  'catadherent' =>$catadherent,
                  'mail' => ('contact@uspeg-gestion.com'),
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
        }
           /**************************************************************/
    
           if(isset($mails)){
        return $this->render('team/index.html.twig', [
            'team' => $team,
            'team1' =>$team1,
            'catadherent' => $catadherent,
            'adherent' => $adherent,
            'mails' => $mails,
            'formcontact' =>$formcontact->createView()
           
        ]);} else {
            return $this->render('team/index.html.twig', [
                'team' => $team,
                'team1' =>$team1,
                'catadherent' => $catadherent,
                'adherent' => $adherent,
                //'mails' => $mails,
                //'formcontact' =>$formcontact->createView()
               
            ]);
        }
    }
}
