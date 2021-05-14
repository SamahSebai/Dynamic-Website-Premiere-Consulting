<?php

namespace App\Repository;

use App\Entity\Offres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Offres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offres[]    findAll()
 * @method Offres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offres::class);
    }

    // /**
    //  * @return Offres[] Returns an array of Offres objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Offres
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /*public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p
                FROM Offres:Offres p
                WHERE p.titre LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }*/
    public function searchBack($term)
    {
        $query=$this->createQueryBuilder('offre')->select('offre');

        $query ->Where('offre.type LIKE :searchTerm or offre.date LIKE :searchTerm or offre.id LIKE :searchTerm  
            or offre.qualification LIKE :searchTerm or offre.description 
             LIKE :searchTerm or offre.experience   LIKE :searchTerm')
            ->setParameter('searchTerm','%' .$term.'%');
        $query ->getQuery()
            ->getResult();
        return $query;
    }
    public function search($term,$tes)
    {
        $query=$this->createQueryBuilder('offre')->select('offre');
        if($term!=""){


            $query ->Where('offre.type LIKE :searchTerm  or offre.qualification LIKE :searchTerm or offre.description  LIKE :searchTerm or offre.experience   LIKE :searchTerm')
                ->setParameter('searchTerm','%' .$term.'%');
            if ($tes==1){
                $query ->andWhere('offre.type LIKE :emp ')
                    ->setParameter('emp','%emploi%');
            }
            if ($tes==2){
                $query ->andWhere('offre.type LIKE :emp ')
                    ->setParameter('emp','%stage%');
            }
        }else{
            if ($tes==1){
                $query ->Where('offre.type LIKE :emp ')
                    ->setParameter('emp','%emploi%');
            }
            if ($tes==2){
                $query ->Where('offre.type LIKE :emp ')
                    ->setParameter('emp','%stage%');
            }

        }
        $query ->getQuery()
            ->getResult();
        return $query;
    }


}
