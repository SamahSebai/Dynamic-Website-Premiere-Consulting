<?php

namespace App\Controller;



use App\Entity\Calendar;
use App\Entity\Formation;
use App\Entity\Valpub;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/calendar")
 */
class CalendarController extends AbstractController
{
    /**
     * @Route("/", name="calendar_index", methods={"GET"})
     */
    public function index(CalendarRepository $calendarRepository): Response
    {
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="calendar_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calendar);
            $entityManager->flush();

            return $this->redirectToRoute('calendar_index');
        }

        return $this->render('calendar/new.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list/", name="calendar_show", methods={"GET"})
     */
    public function show(): Response
    {
        $em=$this->getDoctrine()->getManager();
       /* $em=$this->getDoctrine()->getRepository(Calendar::class);*/
        $date=date('Y-m');
        $d1=$date."-01";
        $d2=$date."-08";
        $l1=$em->getRepository(Calendar::class)->createQueryBuilder('s')
            ->where ('s.start >=:d1 and s.start<:d2')
            ->setParameter('d1',$d1)
            ->setParameter('d2',$d2)
            ->getQuery()->getResult();
         $d1=$date."-08";
        $d2=$date."-15";
        $l2=$em->getRepository(Calendar::class)->createQueryBuilder('s')
            ->where ('s.start >=:d1 and s.start<:d2')
            ->setParameter('d1',$d1)
            ->setParameter('d2',$d2)
            ->getQuery()->getResult();
         $d1=$date."-15";
        $d2=$date."-22";
        $l3=$em->getRepository(Calendar::class)->createQueryBuilder('s')
            ->where ('s.start >=:d1 and s.start<:d2')
            ->setParameter('d1',$d1)
            ->setParameter('d2',$d2)
            ->getQuery()->getResult();
         $d1=$date."-22";
        $d2=$date."-31";
        $l4=$em->getRepository(Calendar::class)->createQueryBuilder('s')
            ->where ('s.start >=:d1 and s.start<=:d2')
            ->setParameter('d1',$d1)
            ->setParameter('d2',$d2)
            ->getQuery()->getResult();

        return $this->render('calendar/show.html.twig', [
            'l1'=>$l1,'l2'=>$l2,'l3'=>$l3,'l4'=>$l4,
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_exemple", methods={"GET"})
     */
    public function show1(Calendar $calendar): Response
    {
        return $this->render('calendar/show1.html.twig', [
            'calendar' => $calendar,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="calendar_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Calendar $calendar): Response
    {
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calendar_index');
        }

        return $this->render('calendar/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calendar_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Calendar $calendar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$calendar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($calendar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('calendar_index');
    }
    /**
     * @Route("/{id}/valider", name="evenement_valider", methods={"GET","POST"})
     */
    public function valider(Request $request, Calendar $calendar): Response
    {
        $form = $this->createForm(Calendar::class, $calendar);
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
            $val->setCalendar($calendar);

            $em= $this->getDoctrine()->getManager();
            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('calendar');
        }


    }
    /**
     * @Route("/{id}/publier", name="evenement_publier", methods={"GET","POST"})
     */
    public function publier(Request $request, Calendar $calendar): Response
    {
        $form = $this->createForm(Calendar::class, $calendar);
        $form->handleRequest($request);

        if ($request->isMethod('post')){
            $val=new Valpub();
            $d= new \DateTime("Now");
            $val->setPublier(true);
            $val->setDate($d);
            $val->setCalendar($calendar);

            $em= $this->getDoctrine()->getManager();
            $em->persist($val);
            $em->flush();

            return $this->redirectToRoute('calendar');
        }


    }




}
