<?php

namespace App\Repository;

use App\Entity\DateCommandes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DateCommandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateCommandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateCommandes[]    findAll()
 * @method DateCommandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateCommandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DateCommandes::class);
    }

    // /**
    //  * @return DateCommandes[] Returns an array of DateCommandes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DateCommandes
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
