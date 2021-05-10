<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeRepository::class)
 */
class Demande
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
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     */
    private $date_de_demande;
    /**
     * @var Formation
     * @ORM\ManyToOne(targetEntity="Formation", inversedBy="Demande")
     * @ORM\JoinColumn(name="formation",referencedColumnName="id")
     */
    private $Formation;
     /**0
     * @var Evenement
     * @ORM\ManyToOne(targetEntity="Calendar", inversedBy="Demande")
     * @ORM\JoinColumn(name="calendar",referencedColumnName="id")
     */
    private $Evenement;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getDateDeDemande(): ?\DateTimeInterface
    {
        return $this->date_de_demande;
    }

    public function setDateDeDemande(\DateTimeInterface $date_de_demande): self
    {
        $this->date_de_demande = $date_de_demande;

        return $this;
    }
}
