<?php

namespace App\Entity;

use App\Repository\CondidatureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CondidatureRepository::class)
 */
class Condidature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CV;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LM;
    /**
     * @ORM\Column(type="integer")
     */
    private $tel;
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
     * @var Offres
     * @ORM\ManyToOne(targetEntity="Offres", inversedBy="Condidature")
     * @ORM\JoinColumn(name="Offres",referencedColumnName="id")
     */
    private $Offres;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Condidature")
     * @ORM\JoinColumn(name="User",referencedColumnName="id")
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCV(): ?string
    {
        return $this->CV;
    }

    public function setCV(string $CV): self
    {
        $this->CV = $CV;

        return $this;
    }

    public function getLM(): ?string
    {
        return $this->LM;
    }

    public function setLM(string $LM): self
    {
        $this->LM = $LM;

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

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $tel
     * @return Condidature
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
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
     * @return Condidature
     */
    public function setUser(User $User): Condidature
    {
        $this->User = $User;
        return $this;
    }

    /**
     * @return Offres
     */
    public function getOffres(): Offres
    {
        return $this->Offres;
    }

    /**
     * @param Offres $Offres
     * @return Condidature
     */
    public function setOffres(Offres $Offres): Condidature
    {
        $this->Offres = $Offres;
        return $this;
    }

}
