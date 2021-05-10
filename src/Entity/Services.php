<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServicesRepository::class)
 */
class Services
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $referance;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="ElementDevis", mappedBy="Services")
     */
    private $ElementDevis;
    /**
     * @ORM\OneToMany(targetEntity="ServicePage", mappedBy="Services")
     */
    private $ServicePage;
    /**
     * @ORM\OneToMany(targetEntity="Valpub", mappedBy="Services")
     */
    private $valpub;


    public function __construct()
    {
        $this->ElementDevis = new ArrayCollection();
        $this->ServicePage = new ArrayCollection();
        $this->valpub = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getReferance(): ?string
    {
        return $this->referance;
    }

    public function setReferance(string $referance): self
    {
        $this->referance = $referance;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
    /**
     * @return Collection|ElementDevis[]
     */
    public function getElementDevis(): Collection
    {
        return $this->ElementDevis;
    }

    public function addElementDevis(ElementDevis $ElementDevis): self
    {
        if (!$this->ElementDevis->contains($ElementDevis)) {
            $this->ElementDevis[] = $ElementDevis;
            $ElementDevis->setServices($this);
        }

        return $this;
    }

    public function removeElementDevis(ElementDevis $ElementDevis): self
    {
        if ($this->ElementDevis->removeElement($ElementDevis)) {
            // set the owning side to null (unless already changed)
            if ($ElementDevis->getServices() === $this) {
                $ElementDevis->setServices(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|ServicePage[]
     */
    public function getServicePage(): Collection
    {
        return $this->ServicePage;
    }

    public function addServicePage(ServicePage $ServicePage): self
    {
        if (!$this->ServicePage->contains($ServicePage)) {
            $this->ServicePage[] = $ServicePage;
            $ServicePage->setServices($this);
        }

        return $this;
    }

    public function removeServicePage(ServicePage $ServicePage): self
    {
        if ($this->ServicePage->removeElement($ServicePage)) {
            // set the owning side to null (unless already changed)
            if ($ServicePage->getServices() === $this) {
                $ServicePage->setServices(null);
            }
        }

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
     * @return Services
     */
    public function setValpub($valpub)
    {
        $this->valpub = $valpub;
        return $this;
    }

}
