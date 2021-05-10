<?php

namespace App\Entity;

use App\Repository\ElementDevisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ElementDevisRepository::class)
 */
class ElementDevis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $prixUnitaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Tax;
    /**
     * @var Devis
     * @ORM\ManyToOne(targetEntity="Devis", inversedBy="ElementDevis")
     * @ORM\JoinColumn(name="Devis",referencedColumnName="id")
     */
    private $Devis;
    /**
     * @var Services
     * @ORM\ManyToOne(targetEntity="Services", inversedBy="ElementDevis")
     * @ORM\JoinColumn(name="Services",referencedColumnName="id")
     */
    private $Services;

    /**
     * @ORM\Column(type="integer")
     */
    private $Quantite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reduction;

    /**
     * @ORM\Column(type="integer")
     */
    private $PTTC;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    /**
     * @param mixed $prixUnitaire
     * @return ElementDevis
     */
    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;
        return $this;
    }

    public function getTAX(): ?string
    {
        return $this->TAX;
    }

    public function setTVA(string $TAX): self
    {
        $this->TAX = $TAX;

        return $this;
    }

    /**
     * @return Services
     */
    public function getServices(): Services
    {
        return $this->Services;
    }

    /**
     * @param Services $Services
     * @return ElementDevis
     */
    public function setServices(Services $Services): ElementDevis
    {
        $this->Services = $Services;
        return $this;
    }

    /**
     * @return Devis
     */
    public function getDevis(): Devis
    {
        return $this->Devis;
    }

    /**
     * @param Devis $Devis
     * @return ElementDevis
     */
    public function setDevis(Devis $Devis): ElementDevis
    {
        $this->Devis = $Devis;
        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->Quantite;
    }

    public function setQuantite(int $Quantite): self
    {
        $this->Quantite = $Quantite;

        return $this;
    }

    public function getReduction(): ?int
    {
        return $this->reduction;
    }

    public function setReduction(?int $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function getPTTC(): ?int
    {
        return $this->PTTC;
    }

    public function setPTTC(int $PTTC): self
    {
        $this->PTTC = $PTTC;

        return $this;
    }


}