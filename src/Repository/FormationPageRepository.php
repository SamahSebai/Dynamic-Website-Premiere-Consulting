<?php

namespace App\Repository;

use App\Entity\FormationPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormationPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationPage[]    findAll()
 * @method FormationPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationPage::class);
    }

    // /**
    //  * @return FormationPage[] Returns an array of FormationPage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormationPage
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
