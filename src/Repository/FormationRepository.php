<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    // /**
    //  * @return Formation[] Returns an array of Formation objects
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
    public function findOneBySomeField($value): ?Formation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function search($term)
    {
        $query=$this->createQueryBuilder('formations')->select('formations');
        $query ->Where('formations.id LIKE :searchTerm 
        or formations.intitule_mission  LIKE :searchTerm or formations.nb_de_jour   LIKE :searchTerm
         or formations.date_debut   LIKE :searchTerm or formations.date_fin  LIKE :searchTerm or 
         formations.localisation_mission   LIKE :searchTerm or formations.cout_provisoire    LIKE :searchTerm 
         or formations.description    LIKE :searchTerm or formations.theme    LIKE :searchTerm ')
            ->setParameter('searchTerm','%' .$term.'%');
        $query ->getQuery()
            ->getResult();
        return $query;
    }
}
