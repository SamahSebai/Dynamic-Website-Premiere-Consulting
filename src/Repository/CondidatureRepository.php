<?php

namespace App\Repository;

use App\Entity\Condidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Condidature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Condidature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Condidature[]    findAll()
 * @method Condidature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CondidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Condidature::class);
    }

    // /**
    //  * @return Condidature[] Returns an array of Condidature objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Condidature
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function search($term)
    {
        $query=$this->createQueryBuilder('condidature')->select('condidature');
        $query ->Where('condidature.id LIKE :searchTerm  or condidature.nom  LIKE :searchTerm or condidature.prenom  LIKE :searchTerm or condidature.email  LIKE :searchTerm')
            ->setParameter('searchTerm','%' .$term.'%');
        $query ->getQuery()
            ->getResult();
        return $query;
    }
}
