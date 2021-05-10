<?php

namespace App\Controller;

use App\Repository\CommantaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommantaireController extends AbstractController
{
    /**
     * @Route("/commantaire", name="commantaire")
     */
    public function index(CommantaireRepository $commantaireRepository): Response
    {
        return $this->render('commantaire/index.html.twig', [
            'Commantaire' => $commantaireRepository->findAll(),
        ]);
    }

}
