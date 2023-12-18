<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $auteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $introduction;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_ajout;

    /**
     * @ORM\Column(type="string")
     */
    private $contenu;


    /**
     * @ORM\OneToMany(targetEntity="Commantaire", mappedBy="Article" , orphanRemoval=true)
     * @ORM\JoinColumn(name="Commantaire",referencedColumnName="id")
     */
    private $Commantaire;


    /**
     * @ORM\OneToMany(targetEntity="ArticleCategorie", mappedBy="Article")
     */
    private $ArticleCategorie;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true )
     */
    private $image;
    /**
     * @ORM\OneToMany(targetEntity="Valpub", mappedBy="article")
     * @ORM\OrderBy({"date" = "ASC"})
     */
    private $valpub;

    /**
     *  * @var SEO
     * @ORM\OneToOne(targetEntity="SEO", mappedBy="article")
     */
    private $seo;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user",referencedColumnName="id")
     */
    private $User;

    public function __construct()
    {
        $this->ArticleCategorie = new ArrayCollection();
        $this->Commantaire = new ArrayCollection();
        $this->valpub = new ArrayCollection();
    }

    /**
     * @return SEO
     */
    public function getSeo(): ?SEO
    {
        return $this->seo;
    }

    /**
     * @param SEO $seo
     * @return Article
     */
    public function setSeo(SEO $seo): self
    {
        $this->seo = $seo;
        return $this;
    }
    


    

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(?string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(?string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(?\DateTimeInterface $date_ajout): self
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }
    /**
     * @return Collection|Commantaire[]
     */
    public function getCommantaire():  Collection
    {
        return $this->Commantaire;
    }


    /**
     * @return ArrayCollection
     */
    public function getArticleCategorie(): ArrayCollection
    {
        return $this->ArticleCategorie;
    }



    /**
     * @param mixed $Commantaire
     * @return Article
     */
    public function setCommantaire($Commantaire)
    {
        $this->Commantaire = $Commantaire;
        return $this;
    }

    /**
     * @param mixed $ArticleCategorie
     * @return Article
     */
    public function setArticleCategorie($ArticleCategorie)
    {
        $this->ArticleCategorie = $ArticleCategorie;
        return $this;
    }



    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValpub()
    {
        return $this->valpub;
    }

    /**
     * @param mixed $valpub
     * @return Article
     */
    public function setValpub($valpub)
    {
        $this->valpub = $valpub;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->User;
    }

    /**
     * @param User $User
     * @return Article
     */
    public function setUser(User $User): Article
    {
        $this->User = $User;
        return $this;
    }


    
}
