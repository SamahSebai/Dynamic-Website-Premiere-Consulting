<?php

namespace App\Controller;

use App\Entity\ArticleCategorie;
use App\Entity\Categorie;
use App\Entity\Article;
use App\Entity\SEO;
use App\Entity\Valpub;
use App\Form\ArticleType;
use App\Form\SEOType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository,Request $request,PaginatorInterface $paginator)
    {
        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('aa');
        if ($search) {
            $articles = $articleRepository->search($search);
        } else {
            $articles = $articleRepository->findAll();
        }
        $article = $paginator->paginate(
            $articles,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('article/index.html.twig', [
            'articles' => $article,
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request ): Response

    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $article = new Article();
        $seo= new SEO();
        $form = $this->createForm(ArticleType::class, $article);
        $form2=$this->createForm(SEOType::class,$seo);
        $form->handleRequest($request);
        $form2->handleRequest($request);
        $max=0;
        $list = $entityManager->getRepository(Categorie::class)->createQueryBuilder('c')->select('c')->orderBy('c.niveau','DESC')->setMaxResults(1)->getQuery()->getOneOrNullResult();
        if ($list)
        {
            $max=$list->getNiveau();
        }
        $tab=array();
        $i=0;
        for ($i=0;$i<=$max;$i++){
            $categories=$entityManager->getRepository(Categorie::class)->findBy(array('niveau'=>$i));
            $tab[$i]=$categories;
        }
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($article);
            $entityManager->flush();
            $listcat =$request->request->get("cat");
            foreach  ($listcat as $c){
                $cat=$entityManager->getRepository(Categorie::class)->find($c);
                if ($cat){
                    $CA=new ArticleCategorie();
                    $CA->setArticle($article);
                    $CA->setCategorie($cat);
                    $entityManager->persist($article);

                    $entityManager->flush();
                }

            }

            $image= $form->get('image')->getData();
            $em = $this->getDoctrine()->getManager();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }

                $article->setImage($newFilename);

            }
            $seo->setArticle($article);
            $entityManager->persist($seo);
            $seo->setDescription($article->getIntroduction());
            $article->setUser($user);
            $em->persist($article);
            $em->flush();
            $this->addFlash('success', 'Article Cree!');
            return $this->redirectToRoute('article');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,'categories' => $categories,
            'form' => $form->createView(),'max'=>$max,'tab'=>$tab,
            'seo' => $seo,
            'form2' => $form2->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);

    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUser($user);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('info', 'Article modifié!');
            return $this->redirectToRoute('article');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }
        $this->addFlash('danger', 'Article supprimé!');
        return $this->redirectToRoute('article');
    }
    /**
     * @Route("/{id}/valider", name="article_valider", methods={"GET","POST"})
     */
    public function valider(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
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
            $val->setArticle($article);

            $em= $this->getDoctrine()->getManager();
            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('article');
        }


    }
    /**
     * @Route("/{id}/publier", name="article_publier", methods={"GET","POST"})
     */
    public function publier(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($request->isMethod('post')){
            $val=new Valpub();
            $d= new \DateTime("Now");
            $val->setPublier(true);
            $val->setDate($d);
            $val->setArticle($article);

            $em= $this->getDoctrine()->getManager();
            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('article');
        }


    }
}
