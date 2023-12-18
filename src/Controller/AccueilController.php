<?php

namespace App\Controller;

use App\Entity\Abonner;
use App\Entity\Article;
use App\Entity\Contact;
use App\Entity\Temoingage;
use App\Form\Abonner1Type;
use App\Form\ArticleType;
use App\Form\ContactType;
use App\Form\TemoingageType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(Request $request,\Swift_Mailer $mailer ,ArticleRepository $artRepo ): Response
    {
        $user = $this->getUser();
        $contact = new Contact();
        $form1 = $this->createForm(ContactType::class ,$contact);
        $form1->handleRequest($request);
        $articlelast = $artRepo->findLastArticles();
        $em=$this->getDoctrine()->getManager();
        $articles = $em->getRepository(Article::class)->findAll();
        $temoingages = $em->getRepository(Temoingage::class)->findAll();
        $abonner= new Abonner();
        $articlelast1 = $artRepo->findLastArticles2();
        $form = $this->createForm(Abonner1Type::class ,$abonner);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $abonner = $form->getData();

            // On crée le message
            $message = (new \Swift_Message('Nouveau abonner'))
                // On attribue l'expéditeur
                ->setSender($abonner->getemail())
                // On attribue le destinataire
                ->setTo('sameh.sebai.0104@gmail.com')
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'emails/abonner.html.twig', compact('abonner')
                    ),
                    'text/html'
                )
            ;
            $d= new \DateTime("Now");
            $abonner->setDateCreationAbonnement($d);
            $em = $this->getDoctrine()->getManager();

            $mailer->send($message);
            $em->persist($abonner);
            $em->flush();
            $this->addFlash('success', 'Votre demande d"abonnement est bien enregistrer ' );
            return $this->redirectToRoute('accueil');
        }

        if ($form1->isSubmitted() && $form1->isValid()) {
            $contact = $form1->getData();

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
            return $this->redirectToRoute('accueil');
        }



        return $this->render('accueil/index.html.twig', [
            'contactForm' => $form1->createView(),'temoingages' => $temoingages,'articlelast' => $articlelast,'articles' => $articles , 'abonnerForm' => $form->createView() ,'articlelast1' => $articlelast1
        ]);
    }
}
