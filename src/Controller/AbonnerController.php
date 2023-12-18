<?php

namespace App\Controller;

use App\Entity\Abonner;
use App\Entity\User;
use App\Form\Abonner1Type;
use App\Repository\AbonnerRepository;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/abonner")
 */
class AbonnerController extends AbstractController
{
    /**
     * @Route("/", name="abonner")
     */
    public function index(Request $request,\Swift_Mailer $mailer ,ArticleRepository $artRepo )
    {

        $abonner= new Abonner();
        $articlelast1 = $artRepo->findLastArticles2();
        $form = $this->createForm(Abonner1Type::class ,$abonner);
        $form->handleRequest($request);

        $roles =$this->getUser()->getRoles();

        if (in_array("ROLE_ADMIN",$roles) ) {
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
                    );
                $d = new \DateTime("Now");
                $abonner->setDateCreationAbonnement($d);
                $em = $this->getDoctrine()->getManager();

                $mailer->send($message);
                $em->persist($abonner);
                $em->flush();
                return $this->redirectToRoute('accueil');
            }


        }else{
            return $this->redirectToRoute('accueil');
        }
        return $this->render('abonner/index.html.twig', ['abonnerForm' => $form->createView(), 'articlelast1' => $articlelast1]);

    }

    /*return $this->render('abonner/index.html.twig', [
        'abonners' => $abonnerRepository->findAll(),
    ]);*/


//    /**
//     * @Route("/new", name="abonner_new", methods={"GET","POST"})
//     */
//    public function new(Request $request): Response
//    {
//        $abonner = new Abonner();
//        $form = $this->createForm(Abonner1Type::class, $abonner);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($abonner);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('abonner_index');
//        }
//
//        return $this->render('abonner/new.html.twig', [
//            'abonner' => $abonner,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}", name="abonner_show", methods={"GET"})
//     */
//    public function show(Abonner $abonner): Response
//    {
//        return $this->render('abonner/show.html.twig', [
//            'abonner' => $abonner,
//        ]);
//    }
//
//    /**
//     * @Route("/{id}/edit", name="abonner_edit", methods={"GET","POST"})
//     */
//    public function edit(Request $request, Abonner $abonner): Response
//    {
//        $form = $this->createForm(Abonner1Type::class, $abonner);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('abonner_index');
//        }
//
//        return $this->render('abonner/edit.html.twig', [
//            'abonner' => $abonner,
//            'form' => $form->createView(),
//        ]);
//    }
//
   /**
    * @Route("/{id}", name="abonner_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
   public function delete(Request $request, Abonner $abonner): Response
  {
      if ($this->isCsrfTokenValid('delete'.$abonner->getId(), $request->request->get('_token'))) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->remove($abonner);
          $entityManager->flush();
          $this->addFlash('danger', 'Abonner supprimé!');
       }

        return $this->redirectToRoute('abonner_index');
   }

    /**
     * @Route("/abonnerlist", name="abonner_index", methods={"GET"})
     */
    public function listabonner(AbonnerRepository $abonnerRepository , Request $request,PaginatorInterface $paginator)
    {
        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('ab');
        if ($search) {
            $abonner = $abonnerRepository->search($search);
        } else {
            $abonner = $abonnerRepository->findAll();
        }
        $abonner = $paginator->paginate(
            $abonner,
            $request->query->getInt('page', 1),
           5
        );


        return $this->render('abonner/indexback.html.twig', [
            'abonner' => $abonner,
        ]);
    }

}
