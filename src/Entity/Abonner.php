<?php

namespace App\Entity;

use App\Repository\AbonnerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbonnerRepository::class)
 */
class Abonner
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
     * @ORM\Column(type="date")
     */
    private $date_creation_abonnement;

    /**
     * @ORM\Column(type="date")
     */
    private $date_suppression_abonnement;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;
     /**
     * @ORM\OneToMany(targetEntity="NewsletterAbonner", mappedBy="Abonner")
     */
    private $NewsletterAbonner;

    public function __construct()
    {
        $this->NewsletterAbonner = new ArrayCollection();
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

    public function getDateCreationAbonnement(): ?\DateTimeInterface
    {
        return $this->date_creation_abonnement;
    }

    public function setDateCreationAbonnement(\DateTimeInterface $date_creation_abonnement): self
    {
        $this->date_creation_abonnement = $date_creation_abonnement;

        return $this;
    }

    public function getDateSuppressionAbonnement(): ?\DateTimeInterface
    {
        return $this->date_suppression_abonnement;
    }

    public function setDateSuppressionAbonnement(\DateTimeInterface $date_suppression_abonnement): self
    {
        $this->date_suppression_abonnement = $date_suppression_abonnement;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

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
     * @return Collection|Newsletter[]
     */
    public function getNewsletter(): Collection
    {
        return $this->Newsletter;
    }

    public function addNewsletter(Newsletter $newsletter): self
    {
        if (!$this->Newsletter->contains($newsletter)) {
            $this->Newsletter[] = $newsletter;
            $newsletter->setAbonner($this);
        }

        return $this;
    }

    public function removeNewsletter(Newsletter $newsletter): self
    {
        if ($this->Newsletter->removeElement($newsletter)) {
            // set the owning side to null (unless already changed)
            if ($newsletter->getAbonner() === $this) {
                $newsletter->setAbonner(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|NewsletterAbonner[]
     */
    public function getNewsletterAbonner(): Collection
    {
        return $this->NewsletterAbonner;
    }

    public function addNewsletterAbonner(NewsletterAbonner $NewsletterAbonner): self
    {
        if (!$this->NewsletterAbonner->contains($newsletterAbonner)) {
            $this->NewsletterAbonner[] = $newsletterAbonner;
            $newsletterAbonner->setAbonner($this);
        }

        return $this;
    }

    public function removeNewsletterAbonner(NewsletterAbonner $newsletterAbonner): self
    {
        if ($this->NewsletterAbonner->removeElement($newsletterAbonner)) {
            // set the owning side to null (unless already changed)
            if ($newsletterAbonner->getAbonner() === $this) {
                $newsletterAbonner->setAbonner(null);
            }
        }

        return $this;
    }


}
