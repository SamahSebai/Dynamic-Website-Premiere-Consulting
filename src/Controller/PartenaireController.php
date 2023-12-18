<?php

namespace App\Controller;


use App\Entity\Media;
use App\Entity\Partenaire;
use App\Form\PartenaireType;
use App\Repository\ArticleRepository;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/partenaire")
 */
class PartenaireController extends AbstractController
{
    /**
     * @Route("/", name="partenaire_index", methods={"GET"})
     */
    public function index(PartenaireRepository $partenaireRepository, Request $request,PaginatorInterface $paginator)
    {
        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('p');
        if ($search) {
            $partenaires = $partenaireRepository->search($search);
        } else {
            $partenaires = $partenaireRepository->findAll();
        }
        $partenaire = $paginator->paginate(
            $partenaires,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('partenaire/index.html.twig', [
            'partenaires' => $partenaire,
        ]);
    }


    /**
     * @Route("/new", name="partenaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var image $image
             */
            $image= $form->get('image')->getData();
            $em = $this->getDoctrine()->getManager();

            $em->persist($partenaire);

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

                $partenaire->setImage($newFilename);
                /* $media = new Media();
                 $media->setURL($newFilename);
                 $media->setPartenaire($partenaire);
                 $em->persist($media);
                 $em->flush();*/
            }

                $partenaire->setUser($user);
                $em->persist($partenaire);
                $em->flush();
                $this->addFlash('success', 'partenaire Creé! ');
                return $this->redirectToRoute('partenaire_index');


        }

        return $this->render('partenaire/new.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/List/", name="partenaire_list", methods={"GET"})
     */
    public function showList(ArticleRepository $articlerepo): Response
    {
        $articlelast1 = $articlerepo->findLastArticles2();
        $em=$this->getDoctrine()->getManager();
        $partenaires = $em->getRepository(Partenaire::class)->findAll();

        return $this->render('partenaire/show1.html.twig', [
            'partenaires' => $partenaires,'articlelast1' => $articlelast1
        ]);
    }


    /**
     * @Route("/{id}", name="partenaire_show", methods={"GET"})
     */
    public function show(Partenaire $partenaire): Response
    {
        return $this->render('partenaire/show.html.twig', [
            'partenaire' => $partenaire,
        ]);
    }



    /**
     * @Route("/{id}/edit", name="partenaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partenaire $partenaire): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partenaire->setUser($user);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('info', 'partenaire modifié!');
            return $this->redirectToRoute('partenaire_index');
        }

        return $this->render('partenaire/edit.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partenaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Partenaire $partenaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partenaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partenaire);
            $entityManager->flush();
        }
        $this->addFlash('danger', 'partenaire supprimé!');
        return $this->redirectToRoute('partenaire_index');
    }
}