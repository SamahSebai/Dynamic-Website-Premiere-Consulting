<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Entity\Temoingage;
use App\Form\TemoingageType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(TemoingageRepository $temoingageRepository, Request $request,PaginatorInterface $paginator)
    {

        $em=$this->getDoctrine()->getManager();

        $search = $request->query->get('t');
        if ($search) {
            $temoingages = $temoingageRepository->search($search);
        } else {
            $temoingages = $temoingageRepository->findAll();
        }
        $temoingage = $paginator->paginate(
            $temoingages,
            $request->query->getInt('page', 1),5
        );

        return $this->render('temoingage/index.html.twig', [
            'temoingages' => $temoingage,
        ]);
    }

    /**
     * @Route("/new", name="temoingage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
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
            $temoingage->setUser($user);
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
    public function showList(ArticleRepository $artRepo): Response
    {$articlelast1 = $artRepo->findLastArticles2();
        $em=$this->getDoctrine()->getManager();
        $temoingages = $em->getRepository(Temoingage::class)->findAll();
        return $this->render('temoingage/show1.html.twig', [
            'temoingages' => $temoingages,'articlelast1' => $articlelast1
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
    public function edit(Request $request, Temoingage $temoingage ): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(TemoingageType::class, $temoingage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $temoingage->setUser($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Temoingage modifié!');
            return $this->redirectToRoute('temoingage_index');
        }

        return $this->render('temoingage/edit.html.twig', [
            'temoingage' => $temoingage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="temoingage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Temoingage $temoingage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$temoingage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($temoingage);
            $entityManager->flush();
        }
            $this->addFlash('danger', 'Temoingage supprimé!');
        return $this->redirectToRoute('temoingage_index');
    }

}
