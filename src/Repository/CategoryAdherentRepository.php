<?php

namespace App\Repository;

use App\Entity\CategoryAdherent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryAdherent|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryAdherent|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryAdherent[]    findAll()
 * @method CategoryAdherent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryAdherentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryAdherent::class);
    }

     /**
      * @return CategoryAdherent[] Returns an array of CategoryAdherent objects
     **/
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?CategoryAdherent
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
