<?php

namespace App\Entity;

use App\Repository\ServicePageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServicePageRepository::class)
 */
class ServicePage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
     /**
     * @var Services
     * @ORM\ManyToOne(targetEntity="Services", inversedBy="ServicePage")
     * @ORM\JoinColumn(name="Services",referencedColumnName="id")
     */
    private $Services;
    /**
     * @var Page
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="ServicePage")
     * @ORM\JoinColumn(name="Page",referencedColumnName="id")
     */
    private $Page;

    public function getId(): ?int
    {
        return $this->id;
    }
}
