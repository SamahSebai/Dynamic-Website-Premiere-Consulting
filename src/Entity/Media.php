<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    private $extention;

    /**
     * @ORM\Column(type="string",length=255 )
     */
    private $URL;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true)
     *
     */
    private $type;
    /**
     * @ORM\OneToMany(targetEntity="PageMedia",mappedBy="Media")
     */
    private $PageMedia;

    /**
     * var Formation
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumn(name="formation",referencedColumnName="id" ,nullable=true)
     */
    private $formation;
    /**
     * var article
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article",referencedColumnName="id" ,nullable=true)
     */
    private $article;


    /**
     * var patenaire
     * @ORM\ManyToOne(targetEntity="Partenaire")
     * @ORM\JoinColumn(name="partenaire",referencedColumnName="id" ,nullable=true)
     */
    private $partenaire;

    public function __construct()
    {
        $this->PageMedia = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtention(): ?string
    {
        return $this->extention;
    }

    public function setExtention(?string $extention): self
    {
        $this->extention = $extention;

        return $this;
    }

    public function getURL(): ?string
    {
        return $this->URL;
    }

    public function setURL(?string $URL): self
    {
        $this->URL = $URL;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
    /**
     * @return ArrayCollection
     */
    public function getPageMedia(): ArrayCollection
    {
        return $this->PageMedia;
    }

    public function addPageMedia(PageMedia $pageMedia): self
    {
        if (!$this->PageMedia->contains($pageMedia)) {
            $this->PageMedia[] = $pageMedia;
            $pageMedia->setMedia($this);
        }

        return $this;
    }

    public function removePageMedia(PageMedia $pageMedia): self
    {
        if ($this->PageMedia->removeElement($pageMedia)) {
            // set the owning side to null (unless already changed)
            if ($pageMedia->getMedia() === $this) {
                $pageMedia->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormation():?Formation
    {
        return $this->formation;
    }

    /**
     * @param mixed $formation
     * @return Media
     */
    public function setFormation(?Formation $formation):self
    {
        $this->formation = $formation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     * @return Media
     */
    public function setArticle($article)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPartenaire()
    {
        return $this->partenaire;
    }

    /**
     * @param mixed $partenaire
     */
    public function setPartenaire($partenaire): void
    {
        $this->partenaire = $partenaire;
    }



}