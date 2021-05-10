<?php

namespace App\Repository;

use App\Entity\PageMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageMedia[]    findAll()
 * @method PageMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageMediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageMedia::class);
    }

    // /**
    //  * @return PageMedia[] Returns an array of PageMedia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PageMedia
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
