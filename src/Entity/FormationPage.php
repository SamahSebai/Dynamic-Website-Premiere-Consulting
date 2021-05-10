<?php

namespace App\Entity;

use App\Repository\FormationPageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationPageRepository::class)
 */
class FormationPage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
     /**
     * @var Page
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="FormationPage")
     * @ORM\JoinColumn(name="Page",referencedColumnName="id")
     */
    private $Page;
    /**
     * @var Formation
     * @ORM\ManyToOne(targetEntity="Formation", inversedBy="FormationPage")
     * @ORM\JoinColumn(name="Formation",referencedColumnName="id")
     */
    private $Formation;

    public function getId(): ?int
    {
        return $this->id;
    }
}
