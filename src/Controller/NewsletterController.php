<?php

namespace App\Controller;

use App\Entity\Abonner;
use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\NewsletterRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/newsletter")
 */
class NewsletterController extends AbstractController
{
    /**
     * @Route("/", name="newsletter", methods={"GET"})
     */
    public function index(NewsletterRepository $newsletterRepository , Request $request, PaginatorInterface $paginator)
    {
        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('ne');
        if ($search) {
            $newsletter = $newsletterRepository->search($search);
        } else {
            $newsletter = $newsletterRepository->findAll();
        }
        $newsletter = $paginator->paginate(
            $newsletter,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('newsletter/index.html.twig', [
            'newsletter' => $newsletter,
        ]);
    }

    /**
     * @Route("/new", name="newsletter_new", methods={"GET","POST"} )
     */
    public function new(Request $request ,\Swift_Mailer $mailer): Response
    {
        $user = $this->getUser();
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);
        $emails = [];
        $abonner = $this->getDoctrine()->getRepository(Abonner::class)->findAll();

        foreach ($abonner as $abonner) {
            $emails[$abonner->getEmail()] = $abonner->getNom();
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $newsletter = $form->getData();

            // On crée le message
            $message = (new \Swift_Message('nouvelle newsletter'))
                // On attribue l'expéditeur
                ->setSender('sameh.sebai.0104@gmail.com')
                // On attribue le destinataire
                ->setcc($emails)
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'emails/newsletter.html.twig', compact('newsletter')
                    ),
                    'text/html'
                )
            ;

            $d= new \DateTime("Now");
            $newsletter->setDate($d);
            $entityManager = $this->getDoctrine()->getManager();
            $mailer->send($message);
            $newsletter->setUser($user);
            $entityManager->persist($newsletter);
            $entityManager->flush();
            $this->addFlash('success', 'Newsletter ajoutée avec succées!');
            return $this->redirectToRoute('newsletter');
        }


        return $this->render('newsletter/new.html.twig', [
            'newsletter' => $newsletter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newsletter_show", methods={"GET"})
     */
    public function show(Newsletter $newsletter): Response
    {
        return $this->render('newsletter/show.html.twig', [
            'newsletter' => $newsletter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="newsletter_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Newsletter $newsletter): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newsletter->setUser($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Newsletter modifié!');
            return $this->redirectToRoute('newsletter');
        }

        return $this->render('newsletter/edit.html.twig', [
            'newsletter' => $newsletter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newsletter_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Newsletter $newsletter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newsletter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($newsletter);
            $entityManager->flush();
            $this->addFlash('danger', 'Newsletter supprimé!');
        }

        return $this->redirectToRoute('newsletter');
    }
//    /**
//     * @Route("/{id}", name="newsletter_delete", methods={"POST"})
//     */
//    public function delete(Request $request, Newsletter $newsletter): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$newsletter->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($newsletter);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('newsletter');
//    }
}
