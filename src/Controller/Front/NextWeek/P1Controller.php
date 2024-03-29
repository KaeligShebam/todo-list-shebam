<?php

namespace App\Controller\Front\NextWeek;

use App\Entity\Task;
use App\Entity\Quote;
use App\Entity\Appointment;
use App\Repository\TaskRepository;
use App\Repository\QuoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AppointmentRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Front\Task\AddTaskP1NextWeekType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Front\Task\ModifyTaskP1NextWeekType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class P1Controller extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/semaine-suivante/p1", name="next_week_p1")
     */
    public function index(TaskRepository $taskList,Request $request): Response
    {
    
        $taskAdd = new Task();
        $form_p1 = $this->createForm(AddTaskP1NextWeekType::class, $taskAdd);
        $notification = null;
        $form_p1->handleRequest($request);
        if ($form_p1->isSubmitted() && $form_p1->isValid()) {
            $this->entityManager->persist($taskAdd);
            $this->entityManager->flush();
            return $this->redirectToRoute("next_week_p1");
        }


        return $this->render('front/next_week/task/p1/list.html.twig', [
            'task' => $taskList->findBy([], ['position' => 'ASC']),
            'form_task_nw_p1_add' => $form_p1->createView(),
            'notification' => $notification,
        ]);
    }

    /**
     * @Route("/semaine-suivante/p1/modifier/{id}", name="modify_task_p1_nw")
     */
    public function modifyTaskP1Cw(Request $request, Task $taskModify): Response
    {
        $form = $this->createForm(ModifyTaskP1NextWeekType::class, $taskModify);
        $notification = null;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskModify = $form->getData();
            $this->entityManager->persist($taskModify);
            $this->entityManager->flush();
            $notification = 'La tâche a été mise à jour !';
            $form = $this->createForm(ModifyTaskP1NextWeekType::class, $taskModify);
        }
        return $this->render('front/next_week/task/p1/modify.html.twig', [
            'form_task_p1_nw_modify' => $form->createView(),
            'notification' => $notification,
            'task' => $taskModify
        ]);
    }

    /**
     * @Route("/semaine-suivante/p1/supprimer/{id}", name="delete_task_nw_p1")
     * @param Task $taskDelete
     * return RedirectResponse
     */
    public function deleteTask(Task $taskDelete): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($taskDelete);
        $em->flush();

        return $this->redirectToRoute("next_week_p1");
    }


    /**
     * @Route("/semaine-suivante/basculer/tache/p1-en-p2/{id}", name="change_task_nw_p1_to_p2")
     * return RedirectResponse
     */
    public function changeTaskToP2Front(Task $task): Response
    {

        $rep = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setChangeTaskForP2CurrentWeek($task->getId());

        return $this->redirectToRoute("next_week_p1");
    }

    /**
     * @Route("/semaine-suivante/basculer/tache/p1/semaine-actuelle/{id}", name="change_task_p1_nw_to_p1_cw")
     * return RedirectResponse
     */
    public function ChangeTaskP1NextWeekToP1CurrentWeek(Task $task): Response
    {
        $rep = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setChangeTaskP1NextWeekToP1CurrentWeek($task->getId());

        return $this->redirectToRoute("next_week_p1");
    }

    /**
     * @Route("/semaine-suivante/fait/p1/{id}", name="done_task_nw_p1_checkbox")
     */
    public function taskDone(Task $taskdone)
    {
        $taskdone->setDone(($taskdone->getDone()) ? false : true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($taskdone);
        $em->flush();

        return new Response("true");
    }

    /**
     * @Route("/reorder", name="reorder")
     */
    public function reorderTaskP1Row(Request $request, TaskRepository $taskRow, AppointmentRepository $appointmentRow, QuoteRepository $quoteRow)
    {
        $cpt = 0;
        switch ($request->request->get("context")) {
            case '1':
                foreach (json_decode($request->request->get("table"), true /* est-ce que je veux un tableau assoc oui (par défaut false) */) as $row) {
                    $task = $taskRow->find($row['id']); //on récupère la task
                    $task->setPosition($cpt); //on definit la position
                    $cpt++; //on ajoute une rangée
                }
            break;

            case '2':
                foreach (json_decode($request->request->get("table"), true) as $row) {
                    $appt = $appointmentRow->find($row['id']);
                    $appt->setPosition($cpt);
                    $cpt++;
                }
            break;

            case '3':
                foreach (json_decode($request->request->get("table"), true) as $row) {
                    $quote = $quoteRow->find($row['id']);
                    $quote->setPosition($cpt);
                    $cpt++;
                }
            break;
        }

        $this->entityManager->flush();
        return new JsonResponse([
            'data' => gettype($request->request->get("context"))
        ]);
    }

    /**
     * @Route("/semaine-suivante/changer-vers-semaine-actuelle/", name="mission_nw_change_to_cw_front")
     */
    public function changeTaskToCurrentWeek(): Response
    {

        $rep1 = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setRemoveTask();

        $rep2 = $this->getDoctrine()
            ->getRepository(Appointment::class)
            ->setRemoveAppointment();

        $rep3 = $this->getDoctrine()
            ->getRepository(Quote::class)
            ->setRemoveQuote();

        $rep4 = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setchangeTaskToCurrentWeek();

        $rep5 = $this->getDoctrine()
            ->getRepository(Appointment::class)
            ->setchangeAppointmentToCurrentWeek();

        $rep6 = $this->getDoctrine()
            ->getRepository(Quote::class)
            ->setchangeQuoteToCurrentWeek();



        return $this->redirectToRoute("next_week_p1");
    }

}
