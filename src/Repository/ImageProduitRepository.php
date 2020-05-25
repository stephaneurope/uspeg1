<?php

namespace App\Repository;

use App\Entity\ImageProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ImageProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageProduit[]    findAll()
 * @method ImageProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageProduit::class);
    }

    // /**
    //  * @return ImageProduit[] Returns an array of ImageProduit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageProduit
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
