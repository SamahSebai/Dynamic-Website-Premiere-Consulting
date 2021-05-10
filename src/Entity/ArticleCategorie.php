<?php

namespace App\Entity;

use App\Repository\ArticleCategorieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleCategorieRepository::class)
 */
class ArticleCategorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var Article
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="ArticleCategorie")
     * @ORM\JoinColumn(name="Article",referencedColumnName="id")
     */
    private $Article;
    /**
     * @var Categorie
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="ArticleCategorie")
     * @ORM\JoinColumn(name="Categorie",referencedColumnName="id")
     */
    private $Categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->Article;
    }

    /**
     * @param Article $Article
     * @return ArticleCategorie
     */
    public function setArticle(Article $Article): ArticleCategorie
    {
        $this->Article = $Article;
        return $this;
    }

    /**
     * @return Categorie
     */
    public function getCategorie(): Categorie
    {
        return $this->Categorie;
    }

    /**
     * @param Categorie $Categorie
     * @return ArticleCategorie
     */
    public function setCategorie(Categorie $Categorie): ArticleCategorie
    {
        $this->Categorie = $Categorie;
        return $this;
    }

}
