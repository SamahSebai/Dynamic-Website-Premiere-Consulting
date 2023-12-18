<?php

namespace App\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
class Page
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $URL;
    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $description;
    /**
     * @ORM\OneToMany(targetEntity="Media", mappedBy="page")
     * @ORM\JoinColumn(name="Media",referencedColumnName="id")
     */
    private $medias;
    /**
     * @Gedmo\Slug(fields={"URL"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user",referencedColumnName="id")
     */
    private $User;


    /**
     * @ORM\OneToMany(targetEntity="PageMedia", mappedBy="Page")
     */
    private $PageMedia;
    /**
     * @ORM\OneToMany(targetEntity="ServicePage", mappedBy="Page")
     */
    private $ServicePage;
    /**
     * @ORM\OneToMany(targetEntity="FormationPage", mappedBy="Page")
     */
    private $FormationPage;
    /**
     * @ORM\OneToMany(targetEntity="OffresPage", mappedBy="Page")
     */
    private $OffresPage;
    /**
     * @ORM\OneToMany(targetEntity="ElementMenu", mappedBy="Page")
     */
    private $ElementMenu;

    /**
     * @ORM\OneToMany(targetEntity="Valpub", mappedBy="Page")
     * @ORM\OrderBy({"date" = "ASC"})
     */
    private $valpub;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;


    /**
     *  * @var SEO
     * @ORM\OneToOne(targetEntity="SEO", mappedBy="Page")
     */
    private $seo;

    public function __construct()
    {
        $this->PageMedia = new ArrayCollection();
        $this->ServicePage = new ArrayCollection();
        $this->FormationPage = new ArrayCollection();
        $this->OffresPage = new ArrayCollection();
        $this->ElementMenu = new ArrayCollection();
        $this->valpub = new ArrayCollection();
    }

    /**
     * @return SEO
     */
    public function getSeo(): ?SEO
    {
        return $this->seo;
    }

    /**
     * @param SEO $seo
     * @return Page
     */
    public function setSeo(SEO $seo): self
    {
        $this->seo = $seo;
        return $this;
    }


    

    public function getId(): ?int
    {
        return $this->id;
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

    public function getURL(): ?string
    {
        return $this->URL;
    }

    public function setURL(string $URL): self
    {
        $this->URL = $URL;

        return $this;
    }
   



     /**
     * @return ArrayCollection
     */
    public function getPageMedia(): ArrayCollection
    {
        return $this->PageMedia;
    }

    public function addPageMedia(PageMedia $PageMedia): self
    {
        if (!$this->PageMedia->contains($pageMedia)) {
            $this->PageMedia[] = $pageMedia;
            $pageMedia->setPage($this);
        }

        return $this;
    }

    public function removePageMedia(PageMedia $pageMedia): self
    {
        if ($this->PageMedia->removeElement($pageMedia)) {
            // set the owning side to null (unless already changed)
            if ($pageMedia->getPage() === $this) {
                $pageMedia->setPage(null);
            }
        }

        return $this;
    }
     /**
     * @return ArrayCollection
     */
    public function getServicePage(): ArrayCollection
    {
        return $this->ServicePage;
    }

    public function addServicePage(ServicePage $ServicePage): self
    {
        if (!$this->ServicePage->contains($ServicePage)) {
            $this->ServicePage[] = $ServicePage;
            $ServicePage->setPage($this);
        }

        return $this;
    }

    public function removeServicePage(ServicePage $ServicePage): self
    {
        if ($this->ServicePage->removeElement($ServicePage)) {
            // set the owning side to null (unless already changed)
            if ($ServicePage->getPage() === $this) {
                $ServicePage->setPage(null);
            }
        }

        return $this;
    }
    /**
     * @return ArrayCollection
     */
    public function getFormationPage():ArrayCollection
    {
        return $this->FormationPage;
    }

    public function addFormationPage(FormationPage $FormationPage): self
    {
        if (!$this->FormationPage->contains($FormationPage)) {
            $this->FormationPage[] = $FormationPage;
            $FormationPage->setPage($this);
        }

        return $this;
    }

    public function removeFormationPage(FormationPage $FormationPage): self
    {
        if ($this->FormationPage->removeElement($FormationPage)) {
            // set the owning side to null (unless already changed)
            if ($FormationPage->getPage() === $this) {
                $FormationPage->setPage(null);
            }
        }

        return $this;
    }
     /**
     * @return ArrayCollection
     */
    public function getOffresPage(): ArrayCollection
    {
        return $this->OffresPage;
    }

    public function addOffresPage(OffresPage $OffresPage): self
    {
        if (!$this->OffresPage->contains($OffresPage)) {
            $this->OffresPage[] = $OffresPage;
            $OffresPage->setPage($this);
        }

        return $this;
    }

    public function removeOffresPage(OffresPage $OffresPage): self
    {
        if ($this->OffresPage->removeElement($OffresPage)) {
            // set the owning side to null (unless already changed)
            if ($OffresPage->getPage() === $this) {
                $OffresPage->setPage(null);
            }
        }

        return $this;
    }
    /**
     * @return ArrayCollection
     */
    public function getElementMenu():ArrayCollection
    {
        return $this->ElementMenu;
    }

    public function addElementMenu(ElementMenu $ElementMenu): self
    {
        if (!$this->ElementMenu->contains($ElementMenu)) {
            $this->ElementMenu[] = $ElementMenu;
            $ElementMenu->setPage($this);
        }

        return $this;
    }

    public function removeElementMenu(ElementMenu $ElementMenu): self
    {
        if ($this->ElementMenu->removeElement($ElementMenu)) {
            // set the owning side to null (unless already changed)
            if ($ElementMenu->getPage() === $this) {
                $ElementMenu->setPage(null);
            }
        }

        return $this;
    }

    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    public function setTemplate(?Template $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

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
     * @return Page
     */
    public function setUser(User $User): Page
    {
        $this->User = $User;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Page
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Page
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return Page
     */
    public function setValpub($valpub)
    {
        $this->valpub = $valpub;
        return $this;
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
     * @return Page
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;
        return $this;
    }


}
