<?php

namespace App\Entity;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 
         * @ORM\Entity
         * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
             * @ORM\Id
             * @ORM\Column(type="integer")
             * @ORM\GeneratedValue(strategy="AUTO")
             */
            protected $id;
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
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;
     /**
     * @ORM\OneToMany(targetEntity="Condidature", mappedBy="User")
     */
    private $Condidature;


    /**
     * @ORM\Column(type="string", length=255,nullable=true )
     */
    private $photo;


    

    public function __construct()
    {
        parent::__construct();
        $this->Condidature = new ArrayCollection();
        // your own logic
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }
    public function __toString():string
    {
        return $this->nom;
    }
     /**
     * @return ArrayCollection
     */
    public function getCondidature(): ArrayCollection
    {
        return $this->Condidature;
    }

    public function addCondidature(Condidature $condidature): self
    {
        if (!$this->Condidature->contains($condidature)) {
            $this->Condidature[] = $condidature;
            $condidature->setUser($this);
        }

        return $this;
    }

    public function removeCondidature(Condidature $condidature): self
    {
        if ($this->Condidature->removeElement($condidature)) {
            // set the owning side to null (unless already changed)
            if ($condidature->getUser() === $this) {
                $condidature->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhoto():?string
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto(?string $photo) :self
    {
        $this->photo = $photo;
        return $this;
    }











}
