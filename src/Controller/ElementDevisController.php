<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\ElementDevis;
use App\Entity\Services;
use App\Form\DevisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ElementDevisController extends AbstractController
{
    /**
     * @Route("/element/devis", name="element_devis")
     */
    public function index(): Response
    {
        return $this->render('element_devis/index.html.twig', [
            'controller_name' => 'ElementDevisController',
        ]);
    }



}
