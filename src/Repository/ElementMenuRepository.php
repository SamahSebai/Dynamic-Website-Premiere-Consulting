<?php

namespace App\Repository;

use App\Entity\ElementMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ElementMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElementMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElementMenu[]    findAll()
 * @method ElementMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElementMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElementMenu::class);
    }

    // /**
    //  * @return ElementMenu[] Returns an array of ElementMenu objects
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
    public function findOneBySomeField($value): ?ElementMenu
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
