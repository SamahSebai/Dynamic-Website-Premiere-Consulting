<?php

namespace App\Entity;

use App\Repository\PageMediaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageMediaRepository::class)
 */
class PageMedia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @var Page
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="PageMedia")
     * @ORM\JoinColumn(name="Page",referencedColumnName="id")
     */
    private $Page;
    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="PageMedia")
     * @ORM\JoinColumn(name="Media",referencedColumnName="id")
     */
    private $Media;
}
