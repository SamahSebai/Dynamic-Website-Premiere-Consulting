<?php

namespace App\Entity;

use App\Repository\SEORepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SEORepository::class)
 */
class SEO
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mot_cle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true)
     */
    private $lien_canonical;
    /**
     *  * @var Page
     * @ORM\OneToOne(targetEntity="Page", inversedBy="seo")
     * @ORM\JoinColumn(name="page",referencedColumnName="id",nullable=true , onDelete="CASCADE")
     */
    private $Page;
    /**
     *  * @var Article
     * @ORM\OneToOne(targetEntity="Article", inversedBy="seo")
     * @ORM\JoinColumn(name="article",referencedColumnName="id", nullable=true, onDelete="CASCADE"  )
     */
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotCle(): ?string
    {
        return $this->mot_cle;
    }

    public function setMotCle(string $mot_cle): self
    {
        $this->mot_cle = $mot_cle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLienCanonical(): ?string
    {
        return $this->lien_canonical;
    }

    public function setLienCanonical(string $lien_canonical): self
    {
        $this->lien_canonical = $lien_canonical;

        return $this;
    }

    /**
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->Page;
    }

    /**
     * @param Page $Page
     * @return SEO
     */
    public function setPage(Page $Page): SEO
    {
        $this->Page = $Page;
        return $this;
    }

    /**
     * @return Page
     */
    public function getArticle(): Page
    {
        return $this->article;
    }

    /**
     * @param Page $article
     * @return SEO
     */
    public function setArticle(Article $article): SEO
    {
        $this->article = $article;
        return $this;
    }

}
