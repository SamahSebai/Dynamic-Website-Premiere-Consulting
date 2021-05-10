<?php

namespace App\Repository;

use App\Entity\ServicePage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServicePage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServicePage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServicePage[]    findAll()
 * @method ServicePage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicePageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServicePage::class);
    }

    // /**
    //  * @return ServicePage[] Returns an array of ServicePage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServicePage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
