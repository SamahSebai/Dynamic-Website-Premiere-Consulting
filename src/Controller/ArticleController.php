<?php

namespace App\Controller;

use App\Entity\ArticleCategorie;
use App\Entity\Categorie;
use App\Entity\Article;
use App\Entity\ValidationEtPublication;
use App\Entity\Valpub;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
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
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response

    {

        $entityManager = $this->getDoctrine()->getManager();
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
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

            $em->persist($article);
            $em->flush();
            $this->addFlash('success', 'Article Created! Knowledge is power!');
            return $this->redirectToRoute('article');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,'categories' => $categories,
            'form' => $form->createView(),'max'=>$max,'tab'=>$tab,
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
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

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
