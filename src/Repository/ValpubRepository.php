<?php

namespace App\Repository;

use App\Entity\Valpub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Valpub|null find($id, $lockMode = null, $lockVersion = null)
 * @method Valpub|null findOneBy(array $criteria, array $orderBy = null)
 * @method Valpub[]    findAll()
 * @method Valpub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValpubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Valpub::class);
    }

    // /**
    //  * @return Valpub[] Returns an array of Valpub objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Valpub
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
