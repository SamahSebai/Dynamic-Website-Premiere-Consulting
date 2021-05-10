<?php

namespace App\Entity;

use App\Repository\NewsletterAbonnerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsletterAbonnerRepository::class)
 */
class NewsletterAbonner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
/**
     * @var Newsletter
     * @ORM\ManyToOne(targetEntity="Newsletter", inversedBy="NewsletterAbonner")
     * @ORM\JoinColumn(name="Newsletter",referencedColumnName="id")
     */
    private $Newsletter;
    /**
     * @var Abonner
     * @ORM\ManyToOne(targetEntity="Abonner", inversedBy="NewsletterAbonner")
     * @ORM\JoinColumn(name="abonner",referencedColumnName="id")
     */
    private $Abonner;

    public function getId(): ?int
    {
        return $this->id;
    }
}
