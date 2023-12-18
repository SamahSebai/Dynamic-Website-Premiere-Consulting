<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ArticleRepository;
use App\Repository\ContactRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact")
     */
    public function index(Request $request,\Swift_Mailer $mailer ,ArticleRepository $articlerepo)
    {
        $user = $this->getUser();
        $contact = new Contact();
        $articlelast1 = $articlerepo->findLastArticles2();
        $form = $this->createForm(ContactType::class ,$contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            // On crée le message
            $message = (new \Swift_Message('Nouveau contact'))
                // On attribue l'expéditeur
                ->setSender($contact->getemail())
                // On attribue le destinataire
                ->setTo('sameh.sebai.0104@gmail.com')
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig', compact('contact')
                    ),
                    'text/html'
                )
            ;
            $em = $this->getDoctrine()->getManager();

            $mailer->send($message);
            if( $user = $this->getUser()){
                $contact->setUser($user);
                $em->persist($contact);
                $em->flush();
            }else
            { $em->persist($contact);
                $em->flush();}
            $this->addFlash('success', 'message envoyer avec succée! ');
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig',['contactForm' => $form->createView(),'articlelast1' => $articlelast1] );
    }


    /**
     * @Route("/contactlist", name="contact_index", methods={"GET"})
     */
    public function listcontact(ContactRepository $contactRepository , Request $request,PaginatorInterface $paginator)
    {
        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('co');
        if ($search) {
            $contact = $contactRepository->search($search);
        } else {
            $contact = $contactRepository->findAll();
        }
        $contact = $paginator->paginate(
            $contact,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('contact/listcontact.html.twig', [
            'contact' => $contact,
        ]);
    }
    /**
     * @Route("/{id}", name="contact_show", methods={"GET"})
     */
    public function show(Contact $contact): Response
    {

        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);

    }
    /**
     * @Route("/{id}", name="contact_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }
        $this->addFlash('danger', 'Contact supprimé!');
        return $this->redirectToRoute('contact_index');
    }
}
