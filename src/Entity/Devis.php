<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DevisRepository::class)
 */
class Devis
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
    private $TVA;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user",referencedColumnName="id")
     *

    private $User; */

    /**
     * @ORM\OneToMany(targetEntity="ElementDevis", mappedBy="Devis")
     */
    private $ElementDevis;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantTTC;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantHT;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entreprise;

    public function __construct()
    {
        $this->ElementDevis = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTVA(): ?string
    {
        return $this->TVA;
    }

    public function setTVA(string $TVA): self
    {
        $this->TVA = $TVA;

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
            $ElementDevis->setDevis($this);
        }

        return $this;
    }

    public function removeElementDevis(ElementDevis $ElementDevis): self
    {
        if ($this->ElementDevis->removeElement($ElementDevis)) {
            // set the owning side to null (unless already changed)
            if ($ElementDevis->getDevis() === $this) {
                $ElementDevis->setDevis(null);
            }
        }

        return $this;
    }

    public function getMontantTTC(): ?int
    {
        return $this->montantTTC;
    }

    public function setMontantTTC(int $montantTTC): self
    {
        $this->montantTTC = $montantTTC;

        return $this;
    }

    public function getMontantHT(): ?int
    {
        return $this->montantHT;
    }

    public function setMontantHT(int $montantHT): self
    {
        $this->montantHT = $montantHT;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

}