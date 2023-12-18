<?php

namespace App\Entity;


use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    private $nom;
    /**
     * @ORM\OneToMany(targetEntity="ArticleCategorie", mappedBy="Categorie")
     */
    private $ArticleCategorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau;
    /**
     * @var Categorie
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="children" )
     * @ORM\JoinColumn(name="parent_id",referencedColumnName="id" )
     */
    private $parent;

    /**
     *
     * @ORM\OneToMany(targetEntity="Categorie", mappedBy="parent")
     * @ORM\JoinColumn(name="children_id",referencedColumnName="id" )
     */
    private $children;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user",referencedColumnName="id")
     */
    private $User;

   


    public function __construct()
    {
        $this->ArticleCategorie = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->niveau="0";

    }
   
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }



    /**
     * @return Categorie
     */
    public function getParent(): ?Categorie
    {
        return $this->parent;
    }

    /**
     * @param Categorie $parent
     * @return Categorie
     */
    public function setParent(?Categorie $parent): Categorie
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     * @return Categorie
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }




    public function __toString()
    {
        return $this->nom;
    }

    /**
     * @return ArrayCollection
     */
    public function getArticleCategorie(): ArrayCollection
    {
        return $this->ArticleCategorie;
    }

    /**
     * @param ArrayCollection $ArticleCategorie
     * @return Categorie
     */
    public function setArticleCategorie(ArrayCollection $ArticleCategorie): Categorie
    {
        $this->ArticleCategorie = $ArticleCategorie;
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
     * @return Categorie
     */
    public function setUser(User $User): Categorie
    {
        $this->User = $User;
        return $this;
    }


}
