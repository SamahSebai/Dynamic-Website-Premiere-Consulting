<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,\Swift_Mailer $mailer)
    {

        $contact = new Contact();
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
            $em->persist($contact);
            $em->flush();
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig',['contactForm' => $form->createView()]);
    }

}
