<?php

namespace App\Entity;
use Symfony\Component\Form\FormTypeInterface;
use App\Repository\OffresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffresRepository::class)
 */
class Offres
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $qualification;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $experience;
     /**
     * @ORM\OneToMany(targetEntity="Condidature", mappedBy="Offres")
     */
    private $Condidature;

     /**
     * @ORM\OneToMany(targetEntity="OffresPage", mappedBy="Offres")
     */
    private $OffresPage;
    /**
     * @ORM\OneToMany(targetEntity="Valpub", mappedBy="offres")
     * @ORM\OrderBy({"date" = "ASC"})
     */
    private $valpub;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user",referencedColumnName="id")
     */
    private $User;

    public function __construct()
    {
        $this->Condidature = new ArrayCollection();
        $this->OffresPage = new ArrayCollection();
    }
    

    

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): self
    {
        $this->nombre = $nombre;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): self
    {
        $this->qualification = $qualification;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     * @return Offres
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return Collection|Condidature[]
     */
    public function getCondidature(): Collection
    {
        return $this->Condidature;
    }

    public function addCondidature(Condidature $condidature): self
    {
        if (!$this->Condidature->contains($condidature)) {
            $this->Condidature[] = $condidature;
            $condidature->setOffres($this);
        }

        return $this;
    }

    public function removeCondidature(Condidature $condidature): self
    {
        if ($this->Condidature->removeElement($condidature)) {
            // set the owning side to null (unless already changed)
            if ($condidature->getOffres() === $this) {
                $condidature->setOffres(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|OffresPage[]
     */
    public function getOffresPage(): Collection
    {
        return $this->OffresPage;
    }

    public function addOffresPage(OffresPage $OffresPage): self
    {
        if (!$this->OffresPage->contains($OffresPage)) {
            $this->OffresPage[] = $OffresPage;
            $OffresPage->setOffres($this);
        }

        return $this;
    }

    public function removeOffresPage(Condidature $OffresPage): self
    {
        if ($this->OffresPage->removeElement($OffresPage)) {
            // set the owning side to null (unless already changed)
            if ($OffresPage->getOffres() === $this) {
                $OffresPage->setOffres(null);
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
     * @return Offres
     */
    public function setValpub($valpub)
    {
        $this->valpub = $valpub;
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
