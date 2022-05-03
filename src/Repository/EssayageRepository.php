<?php

namespace App\Repository;

use App\Entity\Essayage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Essayage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Essayage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Essayage[]    findAll()
 * @method Essayage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EssayageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Essayage::class);
    }

    // /**
    //  * @return Essayage[] Returns an array of Essayage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Essayage
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
