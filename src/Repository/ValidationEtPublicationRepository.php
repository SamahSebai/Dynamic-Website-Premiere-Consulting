<?php

namespace App\Repository;

use App\Entity\ValidationEtPublication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ValidationEtPublication|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValidationEtPublication|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValidationEtPublication[]    findAll()
 * @method ValidationEtPublication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValidationEtPublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ValidationEtPublication::class);
    }

    // /**
    //  * @return ValidationEtPublication[] Returns an array of ValidationEtPublication objects
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
    public function findOneBySomeField($value): ?ValidationEtPublication
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
