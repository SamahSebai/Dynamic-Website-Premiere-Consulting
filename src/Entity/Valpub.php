<?php

namespace App\Entity;

use App\Repository\ValpubRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ValpubRepository::class)
 */
class Valpub
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean" ,nullable=true)
     */
    private $valider;

    /**
     * @ORM\Column(type="boolean" ,nullable=true)
     */
    private $publier;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true)
     */
    private $remarque;

    /**
     * @ORM\Column(type="datetime" ,nullable=true)
     */
    private $date;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userval",referencedColumnName="id" ,nullable=true )
     *
     */
    private $userval;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userpub",referencedColumnName="id" ,nullable=true)
     *
     */
    private $userpub;
    /**
     * @var Article
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="valpub")
     * @ORM\JoinColumn(name="article",referencedColumnName="id",nullable=true)
     */
    private $article;
    /**
     * @var Page
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="Valpub")
     * @ORM\JoinColumn(name="page",referencedColumnName="id" ,nullable=true)
     */
    private $page;
    /**
     * @var Services
     * @ORM\ManyToOne(targetEntity="Services", inversedBy="Valpub")
     * @ORM\JoinColumn(name="service",referencedColumnName="id" ,nullable=true)
     */
    private $service;
    /**
     * @var Offres
     * @ORM\ManyToOne(targetEntity="Offres", inversedBy="valpub")
     * @ORM\JoinColumn(name="offres",referencedColumnName="id",nullable=true)
     */
    private $offres;
    /**
     * @var Formation
     * @ORM\ManyToOne(targetEntity="Formation", inversedBy="valpub")
     * @ORM\JoinColumn(name="formation",referencedColumnName="id",nullable=true)
     */
    private $formation;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValider(): ?bool
    {
        return $this->valider;
    }

    public function setValider(bool $valider): self
    {
        $this->valider = $valider;

        return $this;
    }

    public function getPublier(): ?bool
    {
        return $this->publier;
    }

    public function setPublier(?bool $publier): self
    {
        $this->publier = $publier;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }



    public function getUserval(): ?string
    {
        return $this->userval;
    }

    public function setUserval(string $userval): self
    {
        $this->userval = $userval;

        return $this;
    }

    public function getUserpub(): ?string
    {
        return $this->userpub;
    }

    public function setUserpub(string $userpub): self
    {
        $this->userpub = $userpub;

        return $this;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @param Article $article
     * @return Valpub
     */
    public function setArticle(Article $article): Valpub
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * @param Page $page
     * @return Valpub
     */
    public function setPage(Page $page): Valpub
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return Services
     */
    public function getService(): Services
    {
        return $this->service;
    }

    /**
     * @param Services $service
     * @return Valpub
     */
    public function setService(Services $service): Valpub
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return Valpub
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Offres
     */
    public function getOffres(): Offres
    {
        return $this->offres;
    }

    /**
     * @param Offres $offres
     * @return Valpub
     */
    public function setOffres(Offres $offres): Valpub
    {
        $this->offres = $offres;
        return $this;
    }

    /**
     * @return Formation
     */
    public function getFormation(): Formation
    {
        return $this->formation;
    }

    /**
     * @param Formation $formation
     * @return Valpub
     */
    public function setFormation(Formation $formation): Valpub
    {
        $this->formation = $formation;
        return $this;
    }


}
