<?php

namespace App\Entity;

use App\Repository\OffresPageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffresPageRepository::class)
 */
class OffresPage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
     /**
     * @var Page
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="OffresPage")
     * @ORM\JoinColumn(name="Page",referencedColumnName="id")
     */
    private $Page;
    /**
     * @var Offres
     * @ORM\ManyToOne(targetEntity="Offres", inversedBy="OffresPage")
     * @ORM\JoinColumn(name="Offres",referencedColumnName="id")
     */
    private $Offres;

    public function getId(): ?int
    {
        return $this->id;
    }
}
