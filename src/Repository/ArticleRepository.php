<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findBestArticles()
    {
        return $this->createQueryBuilder('a')
            ->select('a as article ')
            ->join('a.Commantaire', 'c')
            ->groupBy('a')
            ->orderBy('COUNT(c)', 'DESC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function search($term)
    {
        $query=$this->createQueryBuilder('article')->select('article');
        $query ->Where('article.titre LIKE :searchTerm  or article.contenu
         LIKE :searchTerm or article.date_ajout  LIKE :searchTerm or article.auteur  LIKE :searchTerm or article.introduction LIKE :searchTerm')
            ->setParameter('searchTerm','%' .$term.'%');
        $query ->getQuery()
            ->getResult();
        return $query;
    }

}
