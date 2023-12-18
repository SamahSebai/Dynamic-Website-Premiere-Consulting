<?php

namespace App\Controller;
use App\Entity\Abonner;
use App\Entity\Article;
use App\Entity\ArticleCategorie;
use App\Entity\Categorie;
use App\Entity\Commantaire;
use App\Entity\Condidature;
use App\Entity\Contact;
use App\Entity\Devis;
use App\Entity\Evenement;
use App\Entity\Newsletter;
use App\Entity\Offres;
use App\Entity\Page;
use App\Entity\Partenaire;
use App\Entity\User;
use App\Form\ResetPassType;
use App\Form\UserType;
use App\Repository\ArticleRepository;
use App\Repository\CommantaireRepository;
use App\Repository\UserRepository;
use FOS\UserBundle\Model\UserInterface;
use Knp\Component\Pager\PaginatorInterface;

use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class
DefaultController extends AbstractController
{
    /**
     * @Route("/ProfileB",name="ProfileB")
     */
    public function indexAction(Request $request)
    {
        $user=$this->getUser();
        if(!is_object($user)||!$user instanceof UserInterface){
            return $this->redirectToRoute('fos_user_security_login');
        }

        return $this->render('FOSUserBundle:Profile:show.html.twig',['user'=>$user]);
    }
    /**
     * @Route("/Profile",name="Profile")
     */
    public function profile(Request $request,ArticleRepository $artRepo)
    {        $articlelast1 = $artRepo->findLastArticles2();

        $user=$this->getUser();
        if(!is_object($user)||!$user instanceof UserInterface){
            return $this->redirectToRoute('fos_user_security_login');
        }

        return $this->render('profile/index.html.twig',['user'=>$user,'articlelast1' => $articlelast1
]);
    }
    /**
     *@Route("/dashboard",name="dashboard");

    public function dashboarAction(){


        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        return $this->render('utilisateur/dashboard.html.twig', ['users' => $users]);

    }*/

//    /**
//     * @Route("/dashboard", name="stats")
//     */
//    public function statistiques(CommantaireRepository $commantaireRepository){
//        $commentaires = $commantaireRepository->findAll();
//        $dates = [];
//        $articles = [];
//        foreach($commentaires as $commentaire){
//            $date[] = $commentaire->getDate();
//            $article[] = $commentaire->getArticle();
//        }
//        //  $commentaires= $commentaires->countByArticle();
//        return $this->render('accueil/stats.html.twig', [
//            'article' =>json_encode($articles),
//            'date' => json_encode($dates),
//        ]);
//    }

    /**
     * @Route("/user", name="user", methods={"GET"})
     */
    public function index(UserRepository $userRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $em=$this->getDoctrine()->getManager();
        $search = $request->query->get('u');
        if ($search) {
            $user = $userRepository->search($search);
        } else {
            $user = $userRepository->findAll();
        }
        $user = $paginator->paginate(
            $user,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('utilisateur/index.html.twig', [
            'users'=>$user
        ]);
    }
    /**
     * @Route("/user/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->remove("current_password");
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $role = $form->get('role')->getData();
            $image= $form->get('image')->getData();

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

                $user->setPhoto($newFilename);

            }

            $user->setRoles(array($role));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('utilisateur/ajouter.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/editUser/{id}",name="user_edit")
     *
     */


    public function editUserAction(Request $request, User $user ){

        $roles =$this->getUser()->getRoles();

        if (in_array("ROLE_ADMIN",$roles) or ($this->getUser()->getId()==$user->getId())) {

            $em = $this->getDoctrine()->getManager();

            $form = $this->createForm(UserType::class, $user);
            $form->remove("current_password");
            $form->remove("plainPassword");
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $role = $form->get('role')->getData();
                $user->setRoles(array($role));
                $em->persist($user);
                $image= $form->get('image')->getData();

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

                    $user->setPhoto($newFilename);

                }
                $em->flush();
                return $this->redirectToRoute('user');
            }
            return $this->render('utilisateur/editUser.html.twig', [
                'user' => $user,
                'form' => $form->createView()]);
        }
        else{
            return $this->redirectToRoute('accueil');
        }

//        $this->render('utilisateur/editUser.html.twig', array('form' => $form->createView()));
    }





    /**
     * @Route("/editProfil/{id}",name="Profil_edit")
     *
     */


    public function editUserAction1(Request $request, User $user,ArticleRepository $artRepo){


        $articlelast1 = $artRepo->findLastArticles2();



            $em = $this->getDoctrine()->getManager();

            $form = $this->createForm(UserType::class, $user);
            $form->remove("current_password");
            $form->remove("plainPassword");
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $role = $form->get('role')->getData();
                $user->setRoles(array($role));
                $em->persist($user);
                $image= $form->get('image')->getData();

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
                    $user->setPhoto($newFilename);
                }
                $em->flush();
                return $this->redirectToRoute('user');
            }
            return $this->render('utilisateur/editProfil.html.twig', [
                'user' => $user,'articlelast1' => $articlelast1,
                'form' => $form->createView()]);


//        $this->render('utilisateur/editUser.html.twig', array('form' => $form->createView()));
    }







    /**
     * @route("/supprimerutilisateur/{id}",name="supprimer")
     */
    public function supprimer (String $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user=$this->getDoctrine()->getRepository(User::class)->findBy(array('id'=>$id));
        if(!$user) {
            throw $this->createNotFoundException('pas utilisateur avec la id'.$id);
        }
        $entityManager->remove($user[0]);

        $entityManager->flush();
        $this->addFlash('danger', 'Utilisateur supprimé!');
        return $this->redirectToRoute('user');
    }

    /**
     * @Route("usershow/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route("/oubli-pass", name="app_forgotten_password")
     */
    public function oubliPass(Request $request, UserRepository $users, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator
    ): Response
    {
        // On initialise le formulaire
        $form = $this->createForm(ResetPassType::class);
        $token = $tokenGenerator->generateToken();
        $donnees = $form->getData();
        $user = $users->findOneByEmail($donnees['email']);


        // On traite le formulaire
        $form->handleRequest($request);
        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données


            // On cherche un utilisateur ayant cet e-mail

            // Si l'utilisateur n'existe pas
            if ($user === null) {
                // On envoie une alerte disant que l'adresse e-mail est inconnue
                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');

                // On retourne sur la page de connexion
                return $this->redirectToRoute('fos_user_security_login');
            }

            // On génère un token

            // On essaie d'écrire le token en base de données
            try{
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('fos_user_security_login');
            }
        }
        // On génère l'URL de réinitialisation de mot de passe
        $url = $this->generateUrl('app_forgotten_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

        // On génère l'e-mail
        $message = (new \Swift_Message('Mot de passe oublié'))
            ->setFrom('votre@adresse.fr')
            ->setTo($user->getEmail())
            ->setBody(
                "Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée pour le site Nouvelle-Techno.fr. Veuillez cliquer sur le lien suivant : " . $url,
                'text/html'
            )
        ;

        // On envoie l'e-mail
        $mailer->send($message);

        // On crée le message flash de confirmation
        $this->addFlash('message', 'E-mail de réinitialisation du mot de passe envoyé !');

        // On redirige vers la page de login
        return $this->redirectToRoute('app_login');


        // On envoie le formulaire à la vue
        return $this->render('registration/forgotten_password.html.twig',['emailForm' => $form->createView()]);

    }
    /**
     * @Route("/dashboard", name="stats")
     * @IsGranted("ROLE_ADMIN")
     */
    public function statistiques( CommantaireRepository $commantaireRepository){

        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository(Article::class)->findAll();
        $nbart= count($articles);
        $pages =$em->getRepository(Page::class)->findAll();
        $nbpage=count($pages);
        $evenements=$em->getRepository(Evenement::class)->findAll();
        $nbeve= count($evenements);
        $offres=$em->getRepository(Offres::class)->findAll();
        $nboff= count($offres);
        $categories=$em->getRepository(Categorie::class)->findAll();
        $cat= count($categories);
        $devis=$em->getRepository(Devis::class)->findAll();
        $nbdevis= count($devis);
        $candidatures=$em->getRepository(Condidature::class)->findAll();
        $nbcandidat= count($candidatures);
        $abonnees=$em->getRepository(Abonner::class)->findAll();
        $nbabonn= count($abonnees);
        $commentaires=$em->getRepository(Commantaire::class)->findAll();
        $nbcommnt= count($commentaires);
        $newsletter=$em->getRepository(Newsletter::class)->findAll();
        $nbnewsletter= count($newsletter);
        $contact=$em->getRepository(Contact::class)->findAll();
        $nbcontact= count($contact);
        $utilisateur=$em->getRepository(User::class)->findAll();
        $nbutil= count($utilisateur);
        $paretanire=$em->getRepository(Partenaire::class)->findAll();
        $nbparte= count($paretanire);
        $categories=$em->getRepository(Partenaire::class)->findAll();
        $catnom=$categories;

        $roles =$this->getUser()->getRoles();

        if (in_array("ROLE_ADMIN",$roles) ) {



        $em=$this->getDoctrine()->getConnection();
        $query= $em->executeQuery("SELECT COUNT(article_categorie.id) as nb, Categorie.nom as name FROM article_categorie left join Categorie on Categorie.id= article_categorie.Categorie GROUP BY categorie ");
        $cat=$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT nom FROM `categorie` ");
        $catnom=$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM page ");
        $nbpage=$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM commantaire ");
        $nbcommnt=$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM contact ");
        $nbcontact=$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM abonner ");
        $nbabonn=$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM newsletter ");
        $nbnewsletter=$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM evenement ");
        $nbeve =$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM services ");
        $nbservice =$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM condidature ");
        $nbcandidat =$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM devis ");
        $nbdevis =$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM offres GROUP BY  type ");
        $nboff =$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM fos_user");
        $nbutil =$query->fetchAllAssociative();
        $query= $em->executeQuery("SELECT COUNT(id) as nb FROM partenaire");
        $nbparte =$query->fetchAllAssociative();


        return $this->render('stats.html.twig', [
            'nbart' => ($nbart),
            'cat'=>($cat),
            'nbpage' => ($nbpage),
            'nbeve' => ($nbeve),
            'nboff' => ($nboff),
            'nbcommnt'=>($nbcommnt),
            'nbcontact'=>($nbcontact),
            'nbabonn'=>($nbabonn),
            'nbnewsletter'=>($nbnewsletter),
            'nbservice'=>($nbservice),
            'nbcandidat'=>($nbcandidat),
            'nbdevis'=>($nbdevis),
            'nbutil'=>($nbutil),
            'nbpart'=>($nbparte),
            'catnom'=>($catnom),
        ]);

    }else{
return $this->redirectToRoute('accueil');
}

}}
