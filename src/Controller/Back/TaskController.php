<?php

namespace App\Controller\Back;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\QuoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AppointmentRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Back\Task\AddTaskP1NextWeekType;
use App\Form\Back\Task\AddTaskP2NextWeekType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Back\Task\AddTaskP1CurrentWeekType;
use App\Form\Back\Task\AddTaskP2CurrentWeekType;
use App\Form\Back\Task\ModifyTaskP1NextWeekType;
use App\Form\Back\Task\ModifyTaskP2NextWeekType;
use App\Form\Back\Task\ModifyTaskP1CurrentWeekType;
use App\Form\Back\Task\ModifyTaskP2CurrentWeekType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
    $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/liste-des-taches/p1/ajouter", name="add_task_p1_cw_back")
     */
    public function addTaskP1CurrentWeek(Request $request): Response {
        $taskP1cwAdd = new Task();
        $form_p1_cw = $this->createForm(AddTaskP1CurrentWeekType::class, $taskP1cwAdd);
        $notification = null;
        $form_p1_cw->handleRequest($request);
        if($form_p1_cw->isSubmitted() && $form_p1_cw->isValid()) {
            $this->entityManager->persist($taskP1cwAdd);
            $this->entityManager->flush();
            $notification = 'La tâche a bien été ajoutée';
            $taskP1cwAdd = new Task();
            $form = $this->createForm(AddTaskP1CurrentWeekType::class, $taskP1cwAdd);
        }
        return $this->render('back/current_week/task/add_p1.html.twig', [
            'form_task_p1_cw_add_back' => $form_p1_cw->createView(),
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/admin/liste-des-taches/p2/ajouter", name="add_task_p2_cw_back")
     */
    public function addTaskP2CurrentWeek(Request $request): Response
    {
        $taskP2cwAdd = new Task();
        $form_p2_cw = $this->createForm(AddTaskP2CurrentWeekType::class, $taskP2cwAdd);
        $notification = null;
        $form_p2_cw->handleRequest($request);
        if ($form_p2_cw->isSubmitted() && $form_p2_cw->isValid()) {
            $this->entityManager->persist($taskP2cwAdd);
            $this->entityManager->flush();
            $notification = 'La tâche a bien été ajoutée';
            $taskP2cwAdd = new Task();
            $form = $this->createForm(AddTaskP2CurrentWeekType::class, $taskP2cwAdd);
        }
        return $this->render('back/current_week/task/add_p2.html.twig', [
            'form_task_p2_cw_add_back' => $form_p2_cw->createView(),
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/admin/liste-des-taches/semaine-suivante/p1/ajouter", name="add_task_p1_nw_back")
     */
    public function addTaskP1NextWeek(Request $request): Response
    {
        $taskP1nwAdd = new Task();
        $form_p1_nw = $this->createForm(AddTaskP1NextWeekType::class, $taskP1nwAdd);
        $notification = null;
        $form_p1_nw->handleRequest($request);
        if ($form_p1_nw->isSubmitted() && $form_p1_nw->isValid()) {
            $this->entityManager->persist($taskP1nwAdd);
            $this->entityManager->flush();
            $notification = 'La tâche a bien été ajoutée';
            $taskP1cwAdd = new Task();
            $form_p1_nw = $this->createForm(AddTaskP1NextWeekType::class, $taskP1cwAdd);
        }
        return $this->render('back/next_week/task/add_p1.html.twig', [
            'form_task_p1_nw_add_back' => $form_p1_nw->createView(),
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/admin/liste-des-taches/semaine-suivante/p2/ajouter", name="add_task_p2_nw_back")
     */
    public function addTaskP2NextWeek(Request $request): Response
    {
        $taskP2nwAdd = new Task();
        $form_p2_nw = $this->createForm(AddTaskP2NextWeekType::class, $taskP2nwAdd);
        $notification = null;
        $form_p2_nw->handleRequest($request);
        if ($form_p2_nw->isSubmitted() && $form_p2_nw->isValid()) {
            $this->entityManager->persist($taskP2nwAdd);
            $this->entityManager->flush();
            $notification = 'La tâche a bien été ajoutée';
            $taskP2nwAdd = new Task();
            $form = $this->createForm(AddTaskP2NextWeekType::class, $taskP2nwAdd);
        }
        return $this->render('back/next_week/task/add_p2.html.twig', [
            'form_task_p2_nw_add_back' => $form_p2_nw->createView(),
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/admin/liste-des-taches/p1/modifier/id={id}", name="modify_task_p1_cw_back")
     */
    public function modifyTaskP1Cw(Request $request, Task $taskModify): Response
    {
        $form = $this->createForm(ModifyTaskP1CurrentWeekType::class, $taskModify);
        $notification = null;
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $taskModify = $form->getData();
            $this->entityManager->persist($taskModify);
            $this->entityManager->flush();
            $notification = 'La tâche a été mise à jour !';
            $form = $this->createForm(ModifyTaskP1CurrentWeekType::class, $taskModify);
        }
        return $this->render('back/current_week/task/modify_p1.html.twig',[
            'form_task_p1_cw_modify_back' => $form->createView(),
            'notification' => $notification,
            'task' => $taskModify
        ]);   
    }

    /**
     * @Route("/admin/liste-des-taches/p2/modifier/id={id}", name="modify_task_p2_cw_back")
     */
    public function modifyTaskP2CurrentWeek(Request $request, Task $taskModify): Response
    {
        $form = $this->createForm(ModifyTaskP2CurrentWeekType::class, $taskModify);
        $notification = null;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskModify = $form->getData();
            $this->entityManager->persist($taskModify);
            $this->entityManager->flush();
            $notification = 'La tâche a été mise à jour !';
            $form = $this->createForm(ModifyTaskP2CurrentWeekType::class, $taskModify);
        }
        return $this->render('back/current_week/task/modify_p2.html.twig', [
            'form_task_p2_cw_modify_back' => $form->createView(),
            'notification' => $notification,
            'task' => $taskModify
        ]);
    }

    /**
     * @Route("/admin/liste-des-taches/semaine-suivante/p1/modifier/id={id}", name="modify_task_p1_nw_back")
     */
    public function modifyTaskP1NextWeek(Request $request, Task $taskP2ModifyCW): Response
    {
        $form_p1_nw = $this->createForm(ModifyTaskP1NextWeekType::class, $taskP2ModifyCW);
        $notification = null;
        $form_p1_nw->handleRequest($request);

        if ($form_p1_nw->isSubmitted() && $form_p1_nw->isValid()) {
            $taskP2ModifyCW = $form_p1_nw->getData();
            $this->entityManager->persist($taskP2ModifyCW);
            $this->entityManager->flush();
            $notification = 'La tâche a bien été mise à jour !';
            $form_p1_nw = $this->createForm(ModifyTaskP1NextWeekType::class, $taskP2ModifyCW);
        }
        return $this->render('back/next_week/task/modify_p1.html.twig', [
            'form_task_p1_nw_modify_back' => $form_p1_nw->createView(),
            'notification' => $notification,
            'task' => $taskP2ModifyCW
        ]);
    }

    /**
     * @Route("/admin/liste-des-taches/semaine-suivante/p2/modifier/id={id}", name="modify_task_p2_nw_back")
     */
    public function modifyTaskP2NextWeek(Request $request, Task $taskP2ModifyNW): Response
    {
        $form_p2_nw = $this->createForm(ModifyTaskP2NextWeekType::class, $taskP2ModifyNW);
        $notification = null;
        $form_p2_nw->handleRequest($request);

        if ($form_p2_nw->isSubmitted() && $form_p2_nw->isValid()) {
            $taskP2ModifyNW = $form_p2_nw->getData();
            $this->entityManager->persist($taskP2ModifyNW);
            $this->entityManager->flush();
            $notification = 'La tâche a bien été mise à jour !';
            $form_p2_nw = $this->createForm(ModifyTaskP2NextWeekType::class, $taskP2ModifyNW);
        }
        return $this->render('back/next_week/task/modify_p2.html.twig', [
            'form_task_p2_nw_modify_back' => $form_p2_nw->createView(),
            'notification' => $notification,
            'task' => $taskP2ModifyNW
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