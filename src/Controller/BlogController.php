<?php

namespace App\Controller;
use App\Entity\Article;
use App\Entity\Commantaire;
use App\Form\CommantaireType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;






class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
            $em=$this->getDoctrine()->getManager();
            $articles = $em->getRepository(Article::class)->findAll();
                return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    /**
     * @Route("/blog/show/{id}", name="show")
     */

    public function show( $id, ArticleRepository $articlerepo, Request $request ): Response
    {
        $article = $articlerepo->findOneBy(['id' => $id]);

        // Partie commentaires
        // On crée le commentaire "vierge"
        $commantaire = new Commantaire;
        // On génère le formulaire
        $commentForm = $this->createForm(CommantaireType::class, $commantaire);
        $commentForm->handleRequest($request);
        // Traitement du formulaire
        if($commentForm->isSubmitted() && $commentForm->isValid()) {
            $commantaire->setDate(new \DateTime);
            $commantaire->setArticle($article);

            // On récupère le contenu du champ parentid
            $parentid = $commentForm->get("parentid")->getData();

            // On va chercher le commentaire correspondant
            $em = $this->getDoctrine()->getManager();

            if ($parentid != null) {
                $parent = $em->getRepository(Commantaire::class)->find($parentid);
            }

            // On définit le parent
            $commantaire->setParent($parent ?? null);

            $em->persist($commantaire);
            $em->flush();

           $this->addFlash('message', 'Votre commentaire a bien été envoyé');
            return $this->redirectToRoute('show', ['id' => $article->getId()]);


        }

        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView()

        ]);

    }


}
