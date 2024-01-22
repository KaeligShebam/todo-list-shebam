<?php

namespace App\Controller\Front\CurrentWeek;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AppointmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Front\Task\AddTaskP2CurrentWeekType;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\Front\Task\ModifyTaskP2CurrentWeekType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class P2Controller extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/semaine-actuelle/p2", name="current_week_p2")
     */
    public function index(TaskRepository $taskList,Request $request): Response
    {

        $taskp2Add = new Task();
        $form_p2 = $this->createForm(AddTaskP2CurrentWeekType::class, $taskp2Add);
        $notification = null;
        $form_p2->handleRequest($request);
        if ($form_p2->isSubmitted() && $form_p2->isValid()) {
            $this->entityManager->persist($taskp2Add);
            $this->entityManager->flush();
            return $this->redirectToRoute("home");
        }

        return $this->render('front/current_week/task/p2/list.html.twig', [
            'task' => $taskList->findBy([], ['position' => 'ASC']),
            'form_task_cw_p2_add' => $form_p2->createView(),
            'notification' => $notification,
        ]);
    }

    /**
     * @Route("/semaine-actuelle/p2/modifier/{id}", name="modify_task_cw_p2")
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
        return $this->render('front/current_week/task/p2/modify.html.twig', [
            'form_task_p2_cw_modify' => $form->createView(),
            'notification' => $notification,
            'task' => $taskModify
        ]);
    }

    /**
     * @Route("/semaine-actuelle/p2/supprimer/{id}", name="delete_task_cw_p2")
     * @param Task $taskDelete
     * return RedirectResponse
     */
    public function deleteTask(Task $taskDelete): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($taskDelete);
        $em->flush();

        return $this->redirectToRoute("current_week_p2");
    }

    /**
     * @Route("/semaine-actuelle/basculer/p2-en-p1/{id}", name="change_task_cw_to_p1")
     * return RedirectResponse
     */
    public function changeTaskToP1Front(Task $task, TaskRepository $taskRepository): Response
    {
        $taskRepository->setChangeTaskForP1CurrentWeek($task->getId());

        return $this->redirectToRoute("current_week_p2");
    }

    /**
     * @Route("/semaine-actuelle/basculer/p2/semaine-suivante/{id}", name="change_task_p2_cw_to_p2_nw")
     * return RedirectResponse
     */
    public function changeTaskP1CurrentWeekToP1NextWeek(Task $task, TaskRepository $taskRepository): Response
    {
        $taskRepository->setChangeTaskP1CurrentWeekToP1NextWeek($task->getId());

        return $this->redirectToRoute("current_week_p2");
    }

    /**
     * @Route("/semaine-actuelle/basculer/p2/semaine-suivante/{id}", name="change_task_p2_cw_to_p2_nw")
     * return RedirectResponse
     */
    public function changeTaskP2CurrentWeekToP2NextWeek(Task $task, TaskRepository $taskRepository): Response
    {
        $taskRepository->setChangeTaskP2CurrentWeekToP2NextWeek($task->getId());
        
        return $this->redirectToRoute("current_week_p2");
    }

    /**
     * @Route("/semaine-actuelle/fait/p2/{id}", name="done_task_cw_p2_checkbox")
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
    public function reorderTaskP1Row(Request $request, TaskRepository $taskRow, AppointmentRepository $appointmentRow)
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
        }

        $this->entityManager->flush();
        return new JsonResponse([
            'data' => gettype($request->request->get("context"))
        ]);
    }

    /**
     * @Route("/deconnexion", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
