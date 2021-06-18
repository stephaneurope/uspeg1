<?php

namespace App\Repository;

use App\Entity\ImportCsv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImportCsv|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImportCsv|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImportCsv[]    findAll()
 * @method ImportCsv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImportCsvRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImportCsv::class);
    }

    // /**
    //  * @return ImportCsv[] Returns an array of ImportCsv objects
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
    public function findOneBySomeField($value): ?ImportCsv
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
