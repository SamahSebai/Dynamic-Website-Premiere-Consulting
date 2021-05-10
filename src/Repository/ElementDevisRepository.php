<?php

namespace App\Repository;

use App\Entity\ElementDevis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ElementDevis|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElementDevis|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElementDevis[]    findAll()
 * @method ElementDevis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElementDevisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElementDevis::class);
    }

    // /**
    //  * @return ElementDevis[] Returns an array of ElementDevis objects
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
    public function findOneBySomeField($value): ?ElementDevis
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
