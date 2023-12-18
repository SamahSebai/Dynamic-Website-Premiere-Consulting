<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Page;
use App\Entity\SEO;
use App\Form\PageType;
use App\Entity\User;
use App\Form\SEOType;
use App\Entity\Valpub;
use App\Repository\ArticleRepository;
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
            5
        );

        return $this->render('page/index.html.twig', [
            'pages' => $page,
        ]);
    }

    /**
     * @Route("/new", name="page_new", methods={"GET","POST"})
     */
    public function new(Request $request,ArticleRepository $artRepo): Response
    {        $user = $this->getUser();

        $page = new Page();
        $seo= new SEO();
        $media= new Media();
        $articlelast1 = $artRepo->findLastArticles2();

        $user=$this->getUser();
        $form = $this->createForm(PageType::class, $page);
        $form2=$this->createForm(SEOType::class,$seo);
        $form->handleRequest($request);
        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()&& $form2->isSubmitted() && $form2->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $page->setUser($user);
            $page->setDescription($seo->getDescription());
            $entityManager->persist($page);
            $seo->setPage($page);
            $page->setUser($user);

            $entityManager->persist($seo);
            $entityManager->flush();
            $this->addFlash('success', 'page Creé! ');

            return $this->redirectToRoute('page');

        }

        return $this->render('page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
            'seo' => $seo,'media' => $media,
            'form2' => $form2->createView(),
            'articlelast1' => $articlelast1,
        ]);
    }
    /**
     * @Route("/{slug}", name="page_show2", methods={"GET"})
     */
    public function show2(Page $page,ArticleRepository $artRepo): Response
    {        $articlelast1 = $artRepo->findLastArticles2();

        return $this->render('page/showFront.html.twig', [
            'page' => $page,'articlelast1' => $articlelast1

        ]);
    }

    /**
     * @Route("/Back/{id}", name="page_show", methods={"GET"})
     */
    public function show(Page $page,ArticleRepository $artRepo): Response
    {$articlelast1 = $artRepo->findLastArticles2();
        return $this->render('page/show.html.twig', [
            'page' => $page,'articlelast1' => $articlelast1
        ]);
    }


    /**
     * @Route("/{id}/edit", name="page_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Page $page): Response
    {        $user = $this->getUser();

        if ($page->getSeo()){
            $seo =$page->getSeo();
        }else{
            $seo= new SEO();
        }

        $form = $this->createForm(PageType::class, $page);
        $form2=$this->createForm(SEOType::class,$seo);
        $form->handleRequest($request);
        $form2->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()&& $form2->isSubmitted() && $form2->isValid()) {
            $entityManager= $this->getDoctrine()->getManager();
            $seo->setPage($page);
            $page->setUser($user);

            $entityManager->persist($seo);
            $entityManager->flush();
            $this->addFlash('info', 'page modifié!');
            return $this->redirectToRoute('page');
        }

        return $this->render('page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
            'seo' => $seo,
            'form2' => $form2->createView(),
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
        $this->addFlash('danger', 'page supprimée
        !');
        return $this->redirectToRoute('page');
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
    /**
     * @Route("/{id}/valider", name="page_valider", methods={"GET","POST"})
     */
    public function valider(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
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
            $val->setPage($page);

            $em= $this->getDoctrine()->getManager();

            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('page');
        }


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
            $d= new \DateTime("Now");
            $val->setPublier(true);
            $val->setDate($d);
            $val->setPage($page);

            $em= $this->getDoctrine()->getManager();
            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('page');
        }


    }
}
