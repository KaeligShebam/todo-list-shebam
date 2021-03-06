<?php

namespace App\Controller\Back;

use App\Entity\Quote;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Back\Quote\AddQuoteNextWeekType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Back\Quote\AddQuoteCurrentWeekType;
use App\Form\Front\Quote\ModifyQuoteNextWeekType;
use App\Form\Front\Quote\ModifyQuoteCurrentWeekType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuoteController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/semaine-actuelle/devis/ajouter", name="add_quote_cw")
     */
    public function addTaskQuote(Request $request): Response
    {
        $quoteAdd = new Quote();
        $form = $this->createForm(AddQuoteCurrentWeekType::class, $quoteAdd);
        $notification = null;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($quoteAdd);
            $this->entityManager->flush();
            $notification = 'Le devis a bien été ajouté';
            $quoteAdd = new Quote();
            $form = $this->createForm(AddQuoteCurrentWeekType::class, $quoteAdd);
        }
        return $this->render('back/current_week/quote/add.html.twig', [
            'form_quote_cw_add' => $form->createView(),
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/basculer/quote/semaine-actuelle/id={id}", name="change_quote_nw_to_cw")
     * return RedirectResponse
     */
    public function changeQuoteNextToCurrentWeek(Quote $quoteChange): Response
    {
        $rep = $this->getDoctrine()
            ->getRepository(Quote::class)
            ->setChangeQuoteNextWeekToCurrentWeek($quoteChange->getId());

        return $this->redirectToRoute("next_week");
    }

    /**
     * @Route("/semaine-actuelle/devis/supprimer/id={id}", name="delete_quote_cw")
     * @param Quote $quoteDelete
     * return RedirectResponse
     */
    public function deleteAppointment(Quote $quoteDelete): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($quoteDelete);
        $em->flush();

        return $this->redirectToRoute("list_cw_mission_back");;
    }

    /**
     * @Route("/semaine-suivante/devis/ajouter", name="add_quote_nw")
     */
    public function addTaskQuoteNextWeek(Request $request): Response
    {
        $quoteAdd = new Quote();
        $form = $this->createForm(AddQuoteNextWeekType::class, $quoteAdd);
        $notification = null;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($quoteAdd);
            $this->entityManager->flush();
            $notification = 'Le devis a bien été ajouté';
            $quoteAdd = new Quote();
            $form = $this->createForm(AddQuoteNextWeekType::class, $quoteAdd);
        }
        return $this->render('back/next_week/quote/add.html.twig', [
            'form_quote_nw_add_back' => $form->createView(),
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/semaine-suivante/devis/modifier/id={id}", name="modify_quote_nw")
     */
    public function modifyQuoteNextWeek(Request $request, Quote $quoteModify): Response
    {
        $form = $this->createForm(ModifyQuoteNextWeekType::class, $quoteModify);
        $notification = null;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quoteModify = $form->getData();
            $this->entityManager->persist($quoteModify);
            $this->entityManager->flush();
            $notification = 'Le devis a bien été mis à jour !';
            $form = $this->createForm(ModifyQuoteNextWeekType::class, $quoteModify);
        }
        return $this->render('front/next_week/quote/modify.html.twig', [
            'form_quote_nw_modify' => $form->createView(),
            'notification' => $notification,
            'quote' => $quoteModify
        ]);
    }

    /**
     * @Route("/semaine-suivante/devis/supprimer/id={id}", name="delete_quote_nw")
     * @param Quote $quoteDelete
     * return RedirectResponse
     */
    public function deleteAppointmentNextWeek(Quote $quoteDelete): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($quoteDelete);
        $em->flush();

        return $this->redirectToRoute("list_nw_mission_back");;
    }

    /**
     * @Route("/basculer/devis/semaine-suivante/id={id}", name="change_quote_cw_to_nw")
     * return RedirectResponse
     */
    public function changeQuoteCurrentToNextWeek(Quote $quoteChange): Response
    {
        $rep = $this->getDoctrine()
            ->getRepository(Quote::class)
            ->setChangeQuoteCurrentWeekToNextWeek($quoteChange->getId());

        return $this->redirectToRoute("list_cw_mission_back");
    }

}