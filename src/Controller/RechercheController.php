<?php

namespace App\Controller;

use App\Entity\Recherche;
use App\Form\RechercheType;
use App\Repository\ArticleRepository;
use App\Repository\RechercheRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recherche")
 */
class RechercheController extends AbstractController
{
    /**
     * @Route("/", name="recherche_index", methods={"GET"})
     */
    public function index(RechercheRepository $rechercheRepository): Response
    {
        return $this->render('recherche/index.html.twig', [
            'recherches' => $rechercheRepository->findAll(),
        ]);
    }


    /**
     * @Route("/recherche", name="recherche_show", methods={"Post"})
     */
    public function show(Request $request,PaginatorInterface $paginator ,ArticleRepository $artRepo): Response
    {
        $articlelast1 = $artRepo->findLastArticles2();
        $search = $request->request->get('search');
        $tab=explode(' ',$search );
        $tab2=array();
        $k=0;
        foreach ($tab as $e ){
            if ($e){
                $tab2[$k]= $e;
                $k++;
            }

        }
        $ch= implode('|',$tab2);
        $em=$this->getDoctrine()->getConnection();
       $query= $em->executeQuery("select p.id as id, p.titre as titre, p.contenu as contenu, p.slug as url ,1 as elpage from  page p  where   p.titre REGEXP  '".$ch."' or p.contenu  REGEXP  '".$ch."' 
union 
select a.id as id, a.titre as titre, a.contenu as contenu, null as url ,0 as elpage from article a  where   a.titre REGEXP  '".$ch."' or a.contenu  REGEXP  '".$ch."'");
        $recherche=$query->fetchAllAssociative();
       /* $recherche =  $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        $em->persist($search);
        $em->flush();*/
        return $this->render('recherche/show.html.twig', [
            'search' => $search,
            'elements' => $recherche,'articlelast1' => $articlelast1
        ]);
    }


    /**
     * @Route("/{id}", name="recherche_delete", methods={"POST"})
     */
    public function delete(Request $request, Recherche $recherche): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recherche->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recherche);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recherche_index');
    }
}
