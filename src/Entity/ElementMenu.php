<?php

namespace App\Entity;

use App\Repository\ElementMenuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ElementMenuRepository::class)
 */
class ElementMenu
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
    private $niveau;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $parent;
    /**
     * @var Menu
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="ElementMenu")
     * @ORM\JoinColumn(name="Menu",referencedColumnName="id")
     */
    private $Menu;
    /**
     * @var Page
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="ElementMenu")
     * @ORM\JoinColumn(name="Page",referencedColumnName="id")
     */
    private $Page;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }

    public function setParent(string $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
