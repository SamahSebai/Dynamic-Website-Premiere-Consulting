<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
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
    private $designation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;
    /**
     * @ORM\OneToMany(targetEntity="ElementMenu", mappedBy="Menu")
     */
    private $ElementMenu;

    public function __construct()
    {
        $this->ElementMenu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

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
     * @return Collection|ElementMenu[]
     */
    public function getElementMenu(): Collection
    {
        return $this->ElementMenu;
    }

    public function addElementMenu(ElementMenu $ElementMenu): self
    {
        if (!$this->ElementMenu->contains($ElementMenu)) {
            $this->ElementMenu[] = $ElementMenu;
            $ElementMenu->setMenu($this);
        }

        return $this;
    }

    public function removeElementMenu(ElementMenu $ElementMenu): self
    {
        if ($this->ElementMenu->removeElement($ElementMenu)) {
            // set the owning side to null (unless already changed)
            if ($ElementMenu->getMenu() === $this) {
                $ElementMenu->setMenu(null);
            }
        }

        return $this;
    }

}
