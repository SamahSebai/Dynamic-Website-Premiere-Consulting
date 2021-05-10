<?php

namespace App\Entity;

use App\Repository\RechercheRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RechercheRepository::class)
 */
class Recherche
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
    private $date_recherche;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $requete;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resultat;
    /**
      * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user",referencedColumnName="id")
     * 
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRecherche(): ?\DateTimeInterface
    {
        return $this->date_recherche;
    }

    public function setDateRecherche(\DateTimeInterface $date_recherche): self
    {
        $this->date_recherche = $date_recherche;

        return $this;
    }

    public function getRequete(): ?string
    {
        return $this->requete;
    }

    public function setRequete(string $requete): self
    {
        $this->requete = $requete;

        return $this;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(string $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }
}
