<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
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
    private $intitule_mission;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nb_de_jour;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localisation_mission;

    /**
     * @ORM\Column(type="float")
     */
    private $cout_provisoire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user",referencedColumnName="id")
     *
     */
    private $User;
    /**
     * @ORM\OneToMany(targetEntity="Demande", mappedBy="Formation")
     */
    private $Demande;
    /**
     * @ORM\OneToMany(targetEntity="Calendar", mappedBy="Formation")
     */
    private $Calendar;
    /**
     * @ORM\OneToMany(targetEntity="FormationPage", mappedBy="Formation")
     */
    private $FormationPage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity="Valpub", mappedBy="Formation")
     * @ORM\OrderBy({"date" = "ASC"})
     */
    private $valpub;
    /**
     * @ORM\OneToMany(targetEntity="Media", mappedBy="formation")

     */
    private $medias;

    public function __construct()
    {


        $this->medias = new ArrayCollection();
        $this->Demande = new ArrayCollection();
        $this->Calendar= new ArrayCollection();
        $this->FormationPage = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleMission(): ?string
    {
        return $this->intitule_mission;
    }

    public function setIntituleMission(string $intitule_mission): self
    {
        $this->intitule_mission = $intitule_mission;

        return $this;
    }

    public function getNbDeJour(): ?string
    {
        return $this->nb_de_jour;
    }

    public function setNbDeJour(string $nb_de_jour): self
    {
        $this->nb_de_jour = $nb_de_jour;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

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

    public function getLocalisationMission(): ?string
    {
        return $this->localisation_mission;
    }

    public function setLocalisationMission(string $localisation_mission): self
    {
        $this->localisation_mission = $localisation_mission;

        return $this;
    }

    public function getCoutProvisoire(): ?float
    {
        return $this->cout_provisoire;
    }

    public function setCoutProvisoire(float $cout_provisoire): self
    {
        $this->cout_provisoire = $cout_provisoire;

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
    /**
     * @return ArrayCollection
     */
    public function getDemande(): ArrayCollection
    {
        return $this->Demande;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->Demande->contains($demande)) {
            $this->Demande[] = $demande;
            $demande->setFormation($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->Demande->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getFormation() === $this) {
                $demande->setFormation(null);
            }
        }

        return $this;
    }
    /**
     * @return ArrayCollection
     */
    public function getEvenement(): ArrayCollection
    {
        return $this->Evenement;
    }

    public function addEvenement(Evenement $Evenement): self
    {
        if (!$this->Evenement->contains($Evenement)) {
            $this->Evenement[] = $Evenement;
            $Evenement->setFormation($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $Evenement): self
    {
        if ($this->Evenement->removeElement($Evenement)) {
            // set the owning side to null (unless already changed)
            if ($Evenement->getFormation() === $this) {
                $Evenement->setFormation(null);
            }
        }

        return $this;
    }
    /**
     * @return ArrayCollection
     */
    public function getFormationPage(): ArrayCollection
    {
        return $this->FormationPage;
    }

    public function addFormationPage(FormationPage $FormationPage): self
    {
        if (!$this->FormationPage->contains($FormationPage)) {
            $this->FormationPage[] = $FormationPage;
            $FormationPage->setFormation($this);
        }

        return $this;
    }

    public function removeFormationPage(FormationPage $FormationPage): self
    {
        if ($this->FormationPage->removeElement($FormationPage)) {
            // set the owning side to null (unless already changed)
            if ($FormationPage->getFormation() === $this) {
                $FormationPage->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->User;
    }

    /**
     * @param User $User
     * @return Formation
     */
    public function setUser(?User $User): Formation
    {
        $this->User = $User;
        return $this;
    }

    public function __toString()
    {
        return $this->intitule_mission;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

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
     */
    public function setValpub($valpub)
    {
        $this->valpub = $valpub;
    }

    /**
     * @return mixed
     */

    public function getMedias()
    {
        return $this->medias;
    }
    /**
     * @param mixed $medias
     * @return Formation
     */
    public function setMedias(ArrayCollection $medias): Formation
    {
        $this->medias = $medias;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCalendar(): ArrayCollection
    {
        return $this->Calendar;
    }

    /**
     * @param ArrayCollection $Calendar
     * @return Formation
     */
    public function setCalendar(ArrayCollection $Calendar): Formation
    {
        $this->Calendar = $Calendar;
        return $this;
    }



}
