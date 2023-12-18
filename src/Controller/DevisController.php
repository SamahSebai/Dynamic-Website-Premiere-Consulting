<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\ElementDevis;
use App\Entity\Services;
use App\Form\DevisType;
use App\Form\ElementDevisType;
use App\Form\SEOType;
use App\Repository\ArticleRepository;
use App\Repository\DevisRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/devis")
 */
class DevisController extends AbstractController
{

    /**
     * @Route("/", name="devis_index", methods={"GET"})
     */
    public function listdevis(DevisRepository $devisRepository , Request $request,PaginatorInterface $paginator)
    {
        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('de');
        if ($search) {
            $devis = $devisRepository->search($search);
        } else {
            $devis = $devisRepository->findAll();
        }
        $devis = $paginator->paginate(
            $devis,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('devis/index.html.twig', [
            'devis' => $devis,
        ]);
    }

    /**
     * @Route("/new", name="devis_new", methods={"GET","POST"} )
     */
    public function new(Request $request,\Swift_Mailer $mailer ,ArticleRepository $articlerepo): Response
    {
        $articlelast1 = $articlerepo->findLastArticles2();
        $entityManager = $this->getDoctrine()->getManager();
        $devi = new Devis();
        $form = $this->createForm(DevisType::class, $devi);
        $form->remove('TVA');$form->remove('montantTTC');$form->remove('montantHT');$form->remove('reference');$form->remove('date');
       $services=$entityManager->getRepository(Services::class)->findAll();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On crée le message
            $message = (new \Swift_Message('Nouvelle demande devis'))
                // On attribue l'expéditeur
                ->setSender($devi->getemail())
                // On attribue le destinataire
                ->setTo('sameh.sebai.0104@gmail.com')
                // On crée le texte avec la vue

                ->setBody(
                    $this->renderView(
                        'emails/devis.html.twig', compact('devi')
                    ),
                    'text/html'
                )
            ;
            $d= new \DateTime("Now");
            $devi->setDate($d);

            $mailer->send($message);
            $entityManager->persist($devi);

            $entityManager->flush();
            $lser=$request->request->get('lser');
            $tab=explode(',',$lser);
            foreach ($tab as $e){
                if ($e!="" ){
                    $num =str_replace('|','',$e);
                    $num =str_replace('|','',$num);
                    $s= $request->request->get('service'.$num);
                    $q= $request->request->get('quantity'.$num);
                    if ($q>0 && $s!=""){
                        $eld= new ElementDevis();
                        $eld->setQuantite($q);
                        $eld->setDevis($devi);
                        $service=$entityManager->getRepository(Services::class)->find($s);
                        $eld->setServices($service);
                        $entityManager->persist($eld);
                        $entityManager->flush();
                        $this->addFlash('success', 'Devis demander avec succée! ');
                    }
                }

            }
            return $this->redirectToRoute('accueil');
        }
        return $this->render('devis/new.html.twig', [
            'devi' => $devi,'services'=>$services,
            'form' => $form->createView(),'articlelast1' => $articlelast1
        ]);
    }
    /**
         * @Route("/send/{id}", name="devis_send",methods={"GET","POST"})
*/
    public function envoyer(Request $request, \Swift_Mailer $mailer,Devis  $devis ,ArticleRepository $articlerepo): Response
    {$entityManager = $this->getDoctrine()->getManager();
        $articlelast1 = $articlerepo->findLastArticles2();
        $user = $this->getUser();
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message('Nouvelle devis'))

                ->setSender('sameh.sebai.0104@gmail.com')
                ->setTo($devis->getemail())
                ->setBody(
                    $this->renderView(
                        'emails/EnvoiDevis.html.twig', compact('devis')
                    ),
                    'text/html'
                )
            ;
            $d= new \DateTime("Now");
            $devis->setDate($d);
            $mailer->send($message);
            $devis->setUser($user);
            $entityManager->persist($devis);
            $entityManager->flush();
            $this->addFlash('success', 'Devis envoyer avec succée! ');
            return $this->redirectToRoute('devis_index');
        }

        return $this->render('devis/envoyer.html.twig', [
            'devis' => $devis,
            'form' => $form->createView(),'articlelast1' => $articlelast1
        ]);
    }

























    /**
     * @Route("/{id}", name="devis_show", methods={"GET"})
     */
    public function show(Devis $devi): Response
    {
        return $this->render('devis/show.html.twig', [
            'devi' => $devi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="devis_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Devis $devi): Response
    {
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('devis_index');
        }

        return $this->render('devis/edit.html.twig', [
            'devi' => $devi,
            'form' => $form->createView(),
        ]);
    }

   /* /**
     * @Route("/{id}", name="devis_delete", methods={"POST"})

    public function delete(Request $request, Devis $devi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($devi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('devis_index');
        */
    /**
     * @Route("/{id}", name="devis_delete", methods={"DELETE"})
     */
    public function deletedevis(Request $request, Devis $devi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($devi);
            $entityManager->flush();
        }
        $this->addFlash('danger', 'Devis supprimé!');
        return $this->redirectToRoute('devis_index');
    }
}
