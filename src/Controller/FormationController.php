<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Media;
use App\Entity\Valpub;
use App\Form\FormationType;
use App\Repository\ArticleRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="formation_index", methods={"GET"})
     * @param FormationRepository $formationRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(FormationRepository $formationRepository, Request $request,PaginatorInterface $paginator)
    {

        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('f');
        if ($search) {
            $formations = $formationRepository->search($search);
        } else {
            $formations = $formationRepository->findAll();
        }
        $formation = $paginator->paginate(
            $formations,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('formation/index.html.twig', [
            'formations' => $formation,
        ]);
    }
    public function search(FormationRepository $formationRepository, Request $request)
    {
        $search = $request->query->get('f');
        if ($search) {
            $formations = $formationRepository->search($search);
        } else {
            $formations = $formationRepository->findAllOrdered();
        }
    }

    /**
     * @Route("/new", name="formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var image $image
             */
            $image= $form->get('media')->getData();
            $em = $this->getDoctrine()->getManager();
            $formation->setTheme($request->request->get('param'));
            $em->persist($formation);

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


                $media = new Media();
                $media->setURL($newFilename);
                $media->setFormation($formation);
                $formation->setUser($user);
                $em->persist($media);
                $em->flush();
                $this->addFlash('success', 'Formation ajoutée avec succées!');
                return $this->redirectToRoute('formation_index');
            }

        }
        return $this->render('formation/new.html.twig', [
        'formation' => $formation,
        'form' => $form->createView(),
    ]);
    }

    /**
     * @Route("/List/", name="formation_list", methods={"GET"})

     */
    public function showList(  ArticleRepository $artRepo): Response
    {

        $em=$this->getDoctrine()->getManager();
        $articlelast1 = $artRepo->findLastArticles2();

        $theme="";
        $F1=$em->getRepository(Formation::class)->createQueryBuilder('T')
            ->where ('T.theme =:SM ')
            ->setParameter('SM','Systèmes de Management Q/S/E et sociétale')
            ->getQuery()->getResult();
        $F2=$em->getRepository(Formation::class)->createQueryBuilder('T')
            ->where ('T.theme =:S')
            ->setParameter('S','Santé, sécurité du travail')
            ->getQuery()->getResult();

        $F3=$em->getRepository(Formation::class)->createQueryBuilder('T')
            ->where ('T.theme =:O')
            ->setParameter('O','Outils & Techniques')
            ->getQuery()->getResult();
        $F4=$em->getRepository(Formation::class)->createQueryBuilder('T')
            ->where ('T.theme=:E')
            ->setParameter('E','Environnement')
            ->getQuery()->getResult();
        $F5=$em->getRepository(Formation::class)->createQueryBuilder('T')
            ->where ('T.theme=:RS')
            ->setParameter('RS','Risques industriels /classement/ incendie')
            ->getQuery()->getResult();

        $F6=$em->getRepository(Formation::class)->createQueryBuilder('T')
            ->where ('T.theme=:C')
            ->setParameter('C','Communication')
            ->getQuery()->getResult();
        return $this->render('formation/show1.html.twig', [
            'F1'=>$F1,'F2'=>$F2,'F3'=>$F3,'F4'=>$F4,'F5'=>$F5,'F6'=>$F6,'articlelast1' => $articlelast1
        ]);

    }


    /**
     * @Route("/{id}", name="formation_show", methods={"GET"})

     */
    public function show(Formation $formation,ArticleRepository $articlerepo): Response
    {   $articlelast1 = $articlerepo->findLastArticles2();
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,'articlelast1' => $articlelast1
        ]);
    }


    /**
     * @Route("/{id}/edit", name="formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formation $formation): Response
    {        $user = $this->getUser();

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formation->setUser($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Formation $formation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $formation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formation);
            $entityManager->flush();
            $this->addFlash('danger', 'Formation supprimé!');

        }

        return $this->redirectToRoute('formation_index');

    }
    /**
     * @Route("/{id}/valider", name="formation_valider", methods={"GET","POST"})
     */
    public function valider(Request $request, Formation $formation): Response
    {
        $form = $this->createForm(Formation::class, $formation);
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
            $val->setFormation($formation);

            $em= $this->getDoctrine()->getManager();
            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('formation');
        }


    }
    /**
     * @Route("/{id}/publier", name="formation_publier", methods={"GET","POST"})
     */
    public function publier(Request $request, Formation $formation): Response
    {
        $form = $this->createForm(Formation::class, $formation);
        $form->handleRequest($request);

        if ($request->isMethod('post')){
            $val=new Valpub();
            $d= new \DateTime("Now");
            $val->setPublier(true);
            $val->setDate($d);
            $val->setFormation($formation);

            $em= $this->getDoctrine()->getManager();
            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('formation');
        }


    }



    
}
