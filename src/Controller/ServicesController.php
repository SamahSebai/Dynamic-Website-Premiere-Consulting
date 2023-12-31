<?php

namespace App\Controller;

use App\Entity\Services;
use App\Form\ServicesType;
use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/services")
 */
class ServicesController extends AbstractController
{
    /**
     * @Route("/", name="services", methods={"GET"})
     * @param ServicesRepository $servicesRepository
     * @param Request $request
     * @param $paginator
     * @return Response
     */
    public function index(ServicesRepository $servicesRepository, Request $request,PaginatorInterface $paginator)
    {
        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('s');
        if ($search) {
            $services = $servicesRepository->search($search);
        } else {
            $services = $servicesRepository->findAll();
        }
        $service = $paginator->paginate(
            $services,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('services/index.html.twig', [
            'services' => $service,
        ]);
    }
    public function search(ServicesRepository $servicesRepository, Request $request)
    {
        $search = $request->query->get('s');
        if ($search) {
            $services = $servicesRepository->search($search);
        } else {
            $services = $servicesRepository->findAllOrdered();
        }
    }

    /**
     * @Route("/new", name="services_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $service = new Services();
        $form = $this->createForm(ServicesType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $service->setUser($user);
            $entityManager->persist($service);
            $entityManager->flush();
            $this->addFlash('success', 'service Creé! ');
            return $this->redirectToRoute('services');
        }

        return $this->render('services/new.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="services_show", methods={"GET"})
     */
    public function show(Services $service): Response
    {
        return $this->render('services/show.html.twig', [
            'service' => $service,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="services_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Services $service): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ServicesType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->setUser($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'service modifié!');
            return $this->redirectToRoute('services');
        }

        return $this->render('services/edit.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="services_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Services $service): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($service);
            $entityManager->flush();
            $this->addFlash('danger', 'Service supprimé!');
        }

        return $this->redirectToRoute('services');
    }
//    /**
//     * @Route("/{id}/valider", name="service_valider", methods={"GET","POST"})
//     */
//    public function valider(Request $request, Services $service): Response
//    {
//        $form = $this->createForm(ServicesType::class, $service);
//        $form->handleRequest($request);
//
//        if ($request->isMethod('post')){
//            $val=new Valpub();
//            $v=$request->request->get("checkbox");
//            $Req=$request->request->get("remarque");
//            $d= new \DateTime("Now");
//            $val->setVal($v);
//            $val->setReq($Req);
//            $val->setDateDeValidation($d);
//            $val->setServices($service);
//
//            $em= $this->getDoctrine()->getManager();
//            $em->persist($val);
//            $em->flush();
//
//            return $this->redirectToRoute('service');
//        }
//
//        return $this->render('service/edit.html.twig', [
//            'service' => $service,
//            'form' => $form->createView(),
//        ]);
//    }
//    /**
//     * @Route("/{id}/publier", name="service_publier", methods={"GET","POST"})
//     */
//    public function publier(Request $request, Services $service): Response
//    {
//        $form = $this->createForm(ServicesType::class, $service);
//        $form->handleRequest($request);
//
//        if ($request->isMethod('post')){
//            $val=new Valpub();
//            $vu=$request->request->get("checkbox");
//            $d= new \DateTime("Now");
//            $val->setPublier($vu);
//            $val->setDateDePublication($d);
//            $val->setServices($service);
//
//            $em= $this->getDoctrine()->getManager();
//            $em->persist($val);
//            $em->flush();
//
//            return $this->redirectToRoute('service');
//        }
//
//        return $this->render('service/edit.html.twig', [
//            'service' => $service,
//            'form' => $form->createView(),
//        ]);
//    }
}
