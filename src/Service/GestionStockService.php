<?php

namespace App\Service;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class GestionDtockService {
    private $stockplus;
    private $produit;
    private $manager;
    private $twig;
    private $form;

    public function __construct(ObjectManager $manager, Environment $twig, RequestStack $request, $templatePath)
    {   
        
        $this->manager      = $manager;
        $this->twig         = $twig;
        $this->form         = $form;
     
    }


    public function stock(){
    $stockplus = $form['stockplus']->getData();


    if (($produit->getQteinit() + $stockplus) >= 0) {
        $produit->setQteinit($produit->getQteinit() + $stockplus);
        $manager->persist($produit);
        $manager->flush();
        $this->addFlash(
            'success',
            "Le produit {$produit->getTitle()} a bien été modifié !"
        );


        // return $this->redirectToRoute('category_produit',['id' => $produit->getCategoryproduit()->getId(),'withAlert' => true]);

    } else $this->AddFlash(
        'danger',
        "Vous n'avez pas assez de produit en stock  !"
    );
}

}
