<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\Common\Collections\ArrayCollection;
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
    private $objet;
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

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getNewsletterAbonner(): ?ArrayCollection
    {
        return $this->NewsletterAbonner;
    }

    /**
     * @param ArrayCollection $NewsletterAbonner
     * @return Newsletter
     */
    public function setNewsletterAbonner(ArrayCollection $NewsletterAbonner): Newsletter
    {
        $this->NewsletterAbonner = $NewsletterAbonner;
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
     */
    public function setUser(User $User)
    {
        $this->User = $User;
    }


}
