<?php

namespace App\Service;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class PaginationService {
    private $entityClass;
    private $limit = 20;
    private $currentPage = 1;
    private $manager;
    private $twig;
    private $route;
    private $templatePath;
    private $value;
    

    public function __construct(ObjectManager $manager, Environment $twig, RequestStack $request, $templatePath)
    {   
        $this->route        = $request->getCurrentRequest()->attributes->get('_route');
        $this->manager      = $manager;
        $this->twig         = $twig;
        $this->templatePath = $templatePath;
    }

    public function setTemplatePath() {
        $this->templatePath = $templatePath;

        return $this;
    }

    public function getTemplatePath() {
        return $this->templatePath;
    }

    public function setRoute($route) {
        $this->route = $route;

        return $this;
    }
 
    /**
     * Get the value of route
     */ 
    public function getRoute()
    {
        return $route;
    }

    public function display() {
        $this->twig->display($this->templatePath, [
                'page' => $this->currentPage,
                'pages' => $this->getPages(),
                'route' => $this->route
        ]);
    }

    public function getPages() {
        if(empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécifié l'entité sur laquelle nous devons paginer !
            Utilisez la méthode setPage de votre paginationService !");
        }
        // 1) Connaitre le total des enregistrements de la table
            $repo = $this->manager->getRepository($this->entityClass);
        
            $total = count($repo->findAll());
        // 2) Faire la division, l'arrondie et le renvoyer
            $pages = ceil($total / $this->limit);

            return $pages;
    }

    public function getData() {

        if(empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécifié l'entité sur laquelle nous devons paginer !
            Utilisez la méthode setEntityClass de votre paginationService !");
        }

        
        // 1) Calculer l'offset
              $offset = $this->currentPage * $this->limit - $this->limit;

               // 2)Demander au repository de trouver les éléments
        $repo =$this->manager->getRepository($this->entityClass);
           
        $data = $repo->findBy([],['lastName' => 'ASC'],$this->limit, $offset);
        
            
     
        // 3)Renvoyer les éléments en fonctions
            return $data;
    }

    

    /**
     * Set the value of currentPage
     *
     * @return  self
     */ 
    public function setPage($page)
    {
        $this->currentPage = $page;

        return $this;
    }

    /**
     * Get the value of currentPage
     */ 
    public function getPage()
    {
        return $this->currentPage;
    }

    public function setLimit($limit) {
        $this->limit =$limit;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setEntityClass($entityClass) {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getEntityClass() {
      return  $this->entityClass;
    }

    

    
}