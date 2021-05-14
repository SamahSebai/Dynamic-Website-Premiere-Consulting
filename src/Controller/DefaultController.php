<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\ResetPassType;
use App\Form\UserType;
use App\Repository\UserRepository;
use FOS\UserBundle\Model\UserInterface;
use Knp\Component\Pager\PaginatorInterface;

use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/",name="acceuil")
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
     *@Route("/dashboard",name="dashboard");
     */
    public function dashboarAction(){


        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        return $this->render('utilisateur/dashboard.html.twig', ['users' => $users]);

    }
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
            1000
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
     * @IsGranted("ROLE_ADMIN")
     */


    public function editUserAction(Request $request, User $user){

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

                $em->flush();
                return $this->redirectToRoute('user');
            }
            return $this->render('utilisateur/editUser.html.twig', [
                'user' => $user,
                'form' => $form->createView()]);
        }
        return $this->redirectToRoute('fos_user_security_login');

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


}
