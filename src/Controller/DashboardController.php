<?php

namespace App\Controller;


use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("admin/dashboard", name="dashboard")
     */
    public function index(ObjectManager $manager)
    {
        
        $adherents = $manager->createQuery('SELECT COUNT(a) FROM App\Entity\Adherent a')->getSingleScalarResult();
        $boutique = $manager->createQuery("SELECT COUNT(b) FROM App\Entity\CategoryAdherent b WHERE b.title = 'BOUTIQUE' ")->getSingleScalarResult();
        $boutique1 = $manager->createQuery("SELECT COUNT(c) FROM App\Entity\CategoryAdherent c WHERE c.title = 'boutique' ")->getSingleScalarResult();
        
        $produits = $manager->createQuery('SELECT COUNT(p) FROM App\Entity\Produit p')->getSingleScalarResult();
        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('adherents','produits','boutique','boutique1')
        ]);
    }
}
