<?php

namespace App\Controller\Back;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Back\Task\AddTaskNextWeekType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Back\Task\AddTaskCurrentWeekType;
use App\Form\Back\Task\ModifyTaskNextWeekType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Back\Task\ModifyTaskCurrentWeekType;
use App\Repository\AppointmentRepository;
use App\Repository\QuoteRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
    $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/liste-des-taches/ajouter", name="add_task_cw_back")
     */
    public function addTask(Request $request): Response {
        $taskAdd = new Task();
        $form = $this->createForm(AddTaskCurrentWeekType::class, $taskAdd);
        $notification = null;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($taskAdd);
            $this->entityManager->flush();
            $notification = 'La tâche a bien été ajoutée';
            $taskAdd = new Task();
            $form = $this->createForm(AddTaskCurrentWeekType::class, $taskAdd);
        }
            return $this->render('back/current_week/task/add.html.twig', [
                'form_task_cw_add_back' => $form->createView(),
                'notification' => $notification
            ]);
    }

    /**
     * @Route("/admin/liste-des-taches/semaine-suivante/ajouter", name="add_task_nw_back")
     */
    public function addTaskNextWeek(Request $request): Response
    {
        $taskAdd = new Task();
        $form = $this->createForm(AddTaskNextWeekType::class, $taskAdd);
        $notification = null;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($taskAdd);
            $this->entityManager->flush();
            $notification = 'La tâche a bien été ajoutée';
            $taskAdd = new Task();
            $form = $this->createForm(AddTaskNextWeekType::class, $taskAdd);
        }
        return $this->render('back/next_week/task/add.html.twig', [
            'form_task_nw_add_back' => $form->createView(),
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/admin/liste-des-taches/modifier/id={id}", name="modify_task_cw_back")
     */
    public function modifyTask(Request $request, Task $taskModify): Response
    {
        $form = $this->createForm(ModifyTaskCurrentWeekType::class, $taskModify);
        $notification = null;
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $taskModify = $form->getData();
            $this->entityManager->persist($taskModify);
            $this->entityManager->flush();
            $notification = 'La tâche a été mise à jour !';
            $form = $this->createForm(ModifyTaskCurrentWeekType::class, $taskModify);
        }
        return $this->render('back/current_week/task/modify.html.twig',[
            'form_task_cw_modify_back' => $form->createView(),
            'notification' => $notification,
            'task' => $taskModify
        ]);   
    }

    /**
     * @Route("/admin/liste-des-taches/semaine-suivante/modifier/id={id}", name="modify_task_nw_back")
     */
    public function modifyTaskNextWeek(Request $request, Task $taskModify): Response
    {
        $form = $this->createForm(ModifyTaskNextWeekType::class, $taskModify);
        $notification = null;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskModify = $form->getData();
            $this->entityManager->persist($taskModify);
            $this->entityManager->flush();
            $notification = 'La tâche a bien été mise à jour !';
            $form = $this->createForm(ModifyTaskNextWeekType::class, $taskModify);
        }
        return $this->render('back/next_week/task/modify.html.twig', [
            'form_task_nw_modify_back' => $form->createView(),
            'notification' => $notification,
            'task' => $taskModify
        ]);
    }

    /**
     * @Route("/admin/liste-des-taches/supprimer/id={id}", name="delete_task_cw_back")
     * @param Task $task
     * return RedirectResponse
     */
    public function deleteTask(Task $task): RedirectResponse {
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute("list_cw_mission_back");
    }

    /**
     * @Route("/admin/liste-des-taches/semaine-suivante/supprimer/id={id}", name="detete_task_nw_back")
     * @param Task $task
     * return RedirectResponse
     */
    public function deleteTaskNextWeek(Task $task): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute("list_nw_mission_back");
    }

    /**
     * @Route("/admin/liste-des-taches/basculement-vers-p1/id={id}", name="change_task_cw_to_p1_back")
     * return RedirectResponse
     */
    public function ChangeTaskForP1CurrentWeekBack(Task $task): Response
    {

        $rep = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setChangeTaskForP1CurrentWeek($task->getId());

        return $this->redirectToRoute("list_cw_mission_back");
    }

    /**
     * @Route("/admin/liste-des-taches/semaine-suivante/basculement-vers-p1/id={id}", name="change_task_nw_to_p1_back")
     * return RedirectResponse
     */
    public function ChangeTaskForP1NextWeekBack(Task $task): Response
    {

        $rep = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setChangeTaskForP1NextWeek($task->getId());

        return $this->redirectToRoute("list_nw_mission_back");
    }

    /**
     * @Route("/admin/liste-des-taches/basculement-vers-p2/id={id}", name="change_task_cw_to_p2_back")
     * return RedirectResponse
     */
    public function changeTaskToP2CurrentWeek(Task $task): Response
    {

        $rep = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setChangeTaskForP2CurrentWeek($task->getId());

        return $this->redirectToRoute("list_cw_mission_back");
    }

    /**
     * @Route("/admin/liste-des-taches/semaine-suivante/basculement-vers-p2/id={id}", name="change_task_nw_to_p2_back")
     * return RedirectResponse
     */
    public function changeTaskToP2NextWeek(Task $task): Response
    {

        $rep = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setChangeTaskForP2NextWeek($task->getId());

        return $this->redirectToRoute("list_nw_mission_back");
    }

    /**
     * @Route("/admin/liste-des-taches/basculer/p1/semaine-suivante/id={id}", name="change_task_p1_cw_to_p1_nw_back")
     * return RedirectResponse
     */
    public function changeTaskP1CurrentWeekToP1NextWeek(Task $task): Response
    {
        $rep = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setChangeTaskP1CurrentWeekToP1NextWeek($task->getId());

        return $this->redirectToRoute("list_cw_mission_back");
    }

    /**
     * @Route("/admin/liste-des-taches/basculer/p1/semaine-actuelle/id={id}", name="change_task_p1_nw_to_p1_cw_back")
     * return RedirectResponse
     */
    public function changeTaskP1NextWeekToP1CurrentWeek(Task $task): Response
    {
        $rep = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setChangeTaskP1NextWeekToP1CurrentWeek($task->getId());

        return $this->redirectToRoute("list_nw_mission_back");
    }

    /**
     * @Route("/admin/liste-des-taches/basculer/p2/semaine-suivante/id={id}", name="change_task_p2_cw_to_p2_nw_back")
     * return RedirectResponse
     */
    public function changeTaskP2CurrentWeekToP2NextWeek(Task $task): Response
    {
        $rep = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setChangeTaskP2CurrentWeekToP2NextWeek($task->getId());

        return $this->redirectToRoute("list_cw_mission_back");
    }

    /**
     * @Route("/admin/liste-des-taches/basculer/p2/semaine-actuelle/id={id}", name="change_task_p2_nw_to_p2_cw_back")
     * return RedirectResponse
     */
    public function changeTaskP2NextWeekToP2CurrentWeek(Task $task): Response
    {
        $rep = $this->getDoctrine()
            ->getRepository(Task::class)
            ->setChangeTaskP2NextWeekToP2CurrentWeek($task->getId());

        return $this->redirectToRoute("list_nw_mission_back");
    }

    /**
     * @Route("/admin/liste-des-taches/changer-vers-semaine-actuelle/", name="change_task_to_cw_back")
     */
    public function changeTaskToCurrentWeek(TaskRepository $taskRepository, AppointmentRepository $appointmentRepository, QuoteRepository $quoteRepository): Response
    {

        $taskRepository->setRemoveTask();
        $taskRepository->setChangeTaskToCurrentWeek();
        $appointmentRepository->setRemoveAppointment();
        $appointmentRepository->setChangeAppointmentToCurrentWeek();
        $quoteRepository->setRemoveQuote();
        $quoteRepository->setChangeQuoteToCurrentWeek();

        return $this->redirectToRoute("list_nw_mission_back");
    }

}