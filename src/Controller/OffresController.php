<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Condidature;
use App\Entity\Formation;
use App\Entity\Offres;
use App\Entity\Valpub;
use App\Form\OffresType;

use App\Repository\OffresRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/offres")
 */
class OffresController extends AbstractController
{
    /**
     * @Route("/", name="offres_index", methods={"GET"})
     */
    public function index(OffresRepository $offresRepository,Request $request,PaginatorInterface $paginator)
    {


        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('o');
        if ($search) {
            $offres = $offresRepository->searchBack($search);
        } else {
            $offres = $offresRepository->findAll();
        }

        $offre = $paginator->paginate(
            $offres,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('offres/index.html.twig', [
            'offres' => $offre,
        ]);
    }
    public function search(OffresRepository  $offresRepository, Request $request)
    { $search = $request->query->get('o');
        if ($search) {
            $offres = $offresRepository->searchBack($search);
        } else {
            $offres = $offresRepository->findAllOrdered();
        }
    }
    /**
     * @Route("/liste", name="offresF_index", methods={"GET"})
     */
    public function liste(OffresRepository $offresRepository,Request $request,PaginatorInterface $paginator)
    {


        $search = $request->query->get('o');
        $tes=0;
        if ($request->query->get('tes')){
            $tes= $request->query->get('tes');
        }

        if ($search!="" or $tes!=0) {
            $offres = $offresRepository->search($search,$tes);
        } else {
            $offres = $offresRepository->findAll();
        }

        $offre = $paginator->paginate(
            $offres,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('offres/show.html.twig', [
            'offres' => $offre,
        ]);
    }

    /**
     * @Route("/new", name="offres_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $offre = new Offres();
        $form = $this->createForm(OffresType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('offres_index');
        }

        return $this->render('offres/new.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }




    /**
     * @Route("/seulOff/{id}", name="Single-offres_show", methods={"GET"})
     */
    public function show(Offres $offre): Response
    {
        return $this->render('offres/single-offre.html.twig', [
            'offre' => $offre,
        ]);
    }

    /**
     * @Route("/show1", name="offres-back", methods={"GET"})

     * @return Response
     **/
    public function showFront(Offres $offre): Response
    {
        return $this->render('offres/single-offre-back.html.twig', [
            'offre' => $offre,
        ]);
    }
    /**
     * @Route("/{id}", name="offres_show-back", methods={"GET"})
     */
    public function show1(Offres $offre): Response
    {
        return $this->render('offres/single-offre-back.html.twig', [
            'offre' => $offre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="offres_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Offres $offre): Response
    {
        $form = $this->createForm(OffresType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('offres_index');
        }

        return $this->render('offres/edit.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="offres_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Offres $offre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offres_index');
    }



    /*    $em = $this->getDoctrine()->getManager();
       $requestString = $request->get('o');
       $offres =  $em->getRepository('Offres:offre')->findEntitiesByString($requestString);
       if(!$offres) {
           $result['offre']['error'] = "article Not found :( ";
       } else {
           $result['offres'] = $this->getRealEntities($offres);
       }
       return new Response(json_encode($result));
   }
   public function getRealEntities($offres): array
   {
       foreach ($offres as $offres){
           $realEntities[$offres->getId()] = [$offres->getPhoto(),$offres->getTitle()];

       }
       return $realEntities;
   }*/


    /**
     * @Route("/{id}/valider", name="offre_valider", methods={"GET","POST"})
     */
    public function valider(Request $request, Offres $offre): Response
    {
        $form = $this->createForm(Offres::class, $offre);
        $form->handleRequest($request);

        if ($request->isMethod('post')){
            $val=new Valpub();
            $val->setValider(false);
            if ($request->request->get("checkbox")){
                $val->setValider(true);
            }
            $Req=$request->request->get("remarque");
            $d= new \DateTime("Now");

            $val->setRemarque($Req);
            $val->setDate($d);
            $val->setOffres($offre);

            $em= $this->getDoctrine()->getManager();
            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('offre');
        }


    }
    /**
     * @Route("/{id}/publier", name="offre_publier", methods={"GET","POST"})
     */
    public function publier(Request $request, Offres $offre): Response
    {
        $form = $this->createForm(Offres::class, $offre);
        $form->handleRequest($request);

        if ($request->isMethod('post')){
            $val=new Valpub();
            $d= new \DateTime("Now");
            $val->setPublier(true);
            $val->setDate($d);
            $val->setOffres($offre);

            $em= $this->getDoctrine()->getManager();
            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('offre');
        }


    }


}
