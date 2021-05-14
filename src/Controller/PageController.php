<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\PageType;
use App\Entity\User;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/page")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/", name="page", methods={"GET"})
     */
    public function index(PageRepository $pageRepository,Request $request,PaginatorInterface $paginator)
    {
        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('pa');
        if ($search) {
            $pages = $pageRepository->search($search);
        } else {
            $pages = $pageRepository->findAll();
        }
        $page = $paginator->paginate(
            $pages,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('page/index.html.twig', [
            'pages' => $page,
        ]);
    }

    /**
     * @Route("/new", name="page_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $page = new Page();
        $user=$this->getUser();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $page->setUser($user);
            $entityManager->persist($page);
            $entityManager->flush();


            return $this->redirectToRoute('page');

        }

        return $this->render('page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{slug}", name="page_show2", methods={"GET"})
     */
    public function show2(Page $page): Response
    {
        return $this->render('page/showFront.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @Route("/Back/{id}", name="page_show", methods={"GET"})
     */
    public function show(Page $page): Response
    {
        return $this->render('page/show.html.twig', [
            'page' => $page,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="page_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('page');
        }

        return $this->render('page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="page_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Page $page): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('page');
    }
    /**
     * @Route("/{id}/valider", name="page_valider", methods={"GET","POST"})
     */
    public function valider(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($request->isMethod('post')){
            $val=new Valpub();
            $v=$request->request->get("checkbox");
            $Req=$request->request->get("remarque");
            $d= new \DateTime("Now");
            $val->setVal($v);
            $val->setReq($Req);
            $val->setDateDeValidation($d);
            $val->setPage($page);

            $em= $this->getDoctrine()->getManager();
            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('page');
        }

        return $this->render('page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/publier", name="page_publier", methods={"GET","POST"})
     */
    public function publier(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($request->isMethod('post')){
            $val=new Valpub();
            $vu=$request->request->get("checkbox");
            $d= new \DateTime("Now");
            $val->setPublier($vu);
            $val->setDateDePublication($d);
            $val->setPage($page);

            $em= $this->getDoctrine()->getManager();
            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('page');
        }

        return $this->render('page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{slug}-{id}",name="menu.show",requirements={"slug":"[a-z0-9\-]*"})
     */
    public function showfront($id,PageRepository $repo):Response
    {
        $pagesrep=$repo->findAll();
        $pages=$this->$repo->find($id);
        return $this->render('basefront.html.twig', [
            'page'=>$pages, 'pagerep'=>$pagesrep

        ]);
    }
}
