<?php

namespace App\Repository;

use App\Entity\Temoingage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Temoingage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temoingage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temoingage[]    findAll()
 * @method Temoingage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemoingageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temoingage::class);
    }

    // /**
    //  * @return Temoingage[] Returns an array of Temoingage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Temoingage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
