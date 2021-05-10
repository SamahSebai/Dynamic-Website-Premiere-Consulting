<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsletterRepository::class)
 */
class Newsletter
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
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;
    /**
      * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user",referencedColumnName="id")
     * 
     */
    private $User;
    /**
     * @ORM\OneToMany(targetEntity="NewsletterAbonner", mappedBy="Newsletter")
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $newsletterAbonner->setNewsletter($this);
        }

        return $this;
    }

    public function removeNewsletterAbonner(NewsletterAbonner $newsletterAbonner): self
    {
        if ($this->NewsletterAbonner->removeElement($newsletterAbonner)) {
            // set the owning side to null (unless already changed)
            if ($newsletterAbonner->getNewsletter() === $this) {
                $newsletterAbonner->setNewsletter(null);
            }
        }

        return $this;
    }

}
