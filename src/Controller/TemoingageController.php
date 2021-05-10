<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Entity\Temoingage;
use App\Form\TemoingageType;
use App\Repository\TemoingageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/temoingage")
 */
class TemoingageController extends AbstractController
{
    /**
     * @Route("/", name="temoingage_index", methods={"GET"})
     */
    public function index(TemoingageRepository $temoingageRepository): Response
    {
        return $this->render('temoingage/index.html.twig', [
            'temoingages' => $temoingageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="temoingage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $temoingage = new Temoingage();
        $form = $this->createForm(TemoingageType::class, $temoingage);
        $form->handleRequest($request);

        $image= $form->get('image')->getData();
        $em = $this->getDoctrine()->getManager();

        if ($image) {
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $image->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {

            }

            $temoingage->setImage($newFilename);

            $em->persist($temoingage);
            $em->flush();
            $this->addFlash('success', 'Témoingage ajoutée avec succées!');
            return $this->redirectToRoute('temoingage_index');

        }


        return $this->render('temoingage/new.html.twig', [
            'temoingage' => $temoingage,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/List", name="temoingage_list", methods={"GET"})
     */
    public function showList(): Response
    {
        $em=$this->getDoctrine()->getManager();
        $temoingages = $em->getRepository(Temoingage::class)->findAll();
        return $this->render('temoingage/show1.html.twig', [
            'temoingages' => $temoingages,
        ]);
    }
    /**
     * @Route("/{id}", name="temoingage_show", methods={"GET"})
     */
    public function show(Temoingage $temoingage): Response
    {
        return $this->render('temoingage/show.html.twig', [
            'temoingage' => $temoingage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="temoingage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Temoingage $temoingage): Response
    {
        $form = $this->createForm(TemoingageType::class, $temoingage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('temoingage_index');
        }

        return $this->render('temoingage/edit.html.twig', [
            'temoingage' => $temoingage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="temoingage_delete", methods={"POST"})
     */
    public function delete(Request $request, Temoingage $temoingage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$temoingage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($temoingage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('temoingage_index');
    }
}
