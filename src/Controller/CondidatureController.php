<?php

namespace App\Controller;

use App\Entity\Condidature;
use App\Form\CondidatureType;
use App\Repository\ArticleRepository;
use App\Repository\CondidatureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CondidatureController
 * @package App\Controller
 */
/**
 * @Route("/condidature")
 */

class CondidatureController extends AbstractController
{

    /**
     * @Route("/condidature_index", name="condidature_index", methods={"GET"})
     */
    public function  list(CondidatureRepository $condidatureRepository  , Request $request,PaginatorInterface $paginator)
    {
        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('can');
        if ($search) {
            $condidature = $condidatureRepository->search($search);
        } else {
            $condidature = $condidatureRepository->findAll();
        }
        $condidature = $paginator->paginate(
            $condidature,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('condidature/index1.html.twig', [
            'condidature' => $condidature,
        ]);
    }

    /**
     * @Route("/", name="condidature")
      */
    public function index(Request $request, \Swift_Mailer $mailer ,ArticleRepository $artRepo)
    {
        $user = $this->getUser();
        $condidature = new Condidature();
        $articlelast1 = $artRepo->findLastArticles2();
        $form = $this->createForm(CondidatureType::class ,$condidature);
        $form->handleRequest($request);
        $uploads_directory=$this->getParameter('upload_directory');
        if ($form->isSubmitted() && $form->isValid()) {
            $condidature = $form->getData();

            $file= $form->get('CV')->getData();

            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $condidature->setCV($filename);
            // On crée le message
            $message = (new \Swift_Message('Nouvelle condidature spontanée'))
                // On attribue l'expéditeur
                ->setSender($condidature->getemail())
                // On attribue le destinataire
                ->setTo('sameh.sebai.0104@gmail.com')
                // On crée le texte avec la vue

                 ->attach(\Swift_Attachment::fromPath($uploads_directory,'file/pdf'))

                ->setBody(
                    $this->renderView(
                        'emails/condidature.html.twig', compact('condidature')
                    ),
                    'text/html'
                )
            ;
            $d= new \DateTime("Now");
            $condidature->setDate($d);
            $em = $this->getDoctrine()->getManager();

            $mailer->send($message);
            $condidature->setUser($user);
            $em->persist($condidature);
            $em->flush();
            $this->addFlash('success', 'condidature postulée avec succée! ');
            return $this->redirectToRoute('offresF_index');
        }

        return $this->render('condidature/index.html.twig', ['condidatureForm' => $form->createView() ,'articlelast1' => $articlelast1]);
    }
    /**
     * @Route("/{id}", name="condidature_show", methods={"GET"})
     */
    public function show(Condidature $condidature): Response
    {
        return $this->render('condidature/show.html.twig', [
            'condidature' => $condidature,
        ]);
    }


    /**
     * @Route("/{id}", name="condidature_delete")
     */
    public function delete(Request $request, Condidature $condidature): Response
    {
        if ($this->isCsrfTokenValid('delete'.$condidature->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($condidature);
            $entityManager->flush();
        }

        return $this->redirectToRoute('condidature_index');
    }

}
