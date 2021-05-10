<?php

namespace App\Controller;

use App\Entity\SEO;
use App\Form\SEOType;
use App\Repository\SEORepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/s/e/o")
 */
class SEOController extends AbstractController
{
    /**
     * @Route("/", name="s_e_o_index", methods={"GET"})
     */
    public function index(SEORepository $sEORepository): Response
    {
        return $this->render('seo/index.html.twig', [
            's_e_os' => $sEORepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="s_e_o_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sEO = new SEO();
        $form = $this->createForm(SEOType::class, $sEO);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sEO);
            $entityManager->flush();

            return $this->redirectToRoute('s_e_o_index');
        }

        return $this->render('seo/new.html.twig', [
            's_e_o' => $sEO,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="s_e_o_show", methods={"GET"})
     */
    public function show(SEO $sEO): Response
    {
        return $this->render('seo/show.html.twig', [
            's_e_o' => $sEO,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="s_e_o_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SEO $sEO): Response
    {
        $form = $this->createForm(SEOType::class, $sEO);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s_e_o_index');
        }

        return $this->render('seo/edit.html.twig', [
            's_e_o' => $sEO,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="s_e_o_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SEO $sEO): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sEO->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sEO);
            $entityManager->flush();
        }

        return $this->redirectToRoute('s_e_o_index');
    }
}
