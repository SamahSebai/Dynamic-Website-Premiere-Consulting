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
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id",referencedColumnName="id")
     */
    private $parent;

    /**
     *
     * @ORM\OneToMany(targetEntity="Categorie", mappedBy="parent")
     * @ORM\JoinColumn(name="children_id",referencedColumnName="id")
     */
    private $children;

    

   


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
     /**
     * @return Collection|ArticleCategorie[]
     */
    public function getArticleCategorie(): Collection
    {
        return $this->ArticleCategorie;
    }

    public function addArticleCategorie(ArticleCategorie $ArticleCategorie): self
    {
        if (!$this->ArticleCategorie->contains($ArticleCategorie)) {
            $this->ArticleCategorie[] = $ArticleCategorie;
            $ArticleCategorie->setCategorie($this);
        }

        return $this;
    }

    public function removeArticleCategorie(Condidature $ArticleCategorie): self
    {
        if ($this->ArticleCategorie->removeElement($ArticleCategorie)) {
            // set the owning side to null (unless already changed)
            if ($ArticleCategorie->getCategorie() === $this) {
                $ArticleCategorie->setCategorie(null);
            }
        }

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


}
