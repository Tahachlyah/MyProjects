<?php

namespace App\Controller;

use App\Entity\Duration;
use App\Form\DurationType;
use App\Repository\DurationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/duration')]
class DurationController extends AbstractController
{
    #[Route('/', name: 'app_duration_index', methods: ['GET'])]
    public function index(DurationRepository $durationRepository): Response
    {
        return $this->render('duration/index.html.twig', [
            'durations' => $durationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_duration_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DurationRepository $durationRepository): Response
    {
        $duration = new Duration();
        $form = $this->createForm(DurationType::class, $duration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $durationRepository->save($duration, true);

            return $this->redirectToRoute('app_duration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('duration/new.html.twig', [
            'duration' => $duration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_duration_show', methods: ['GET'])]
    public function show(Duration $duration): Response
    {
        return $this->render('duration/show.html.twig', [
            'duration' => $duration,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_duration_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Duration $duration, DurationRepository $durationRepository): Response
    {
        $form = $this->createForm(DurationType::class, $duration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $durationRepository->save($duration, true);

            return $this->redirectToRoute('app_duration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('duration/edit.html.twig', [
            'duration' => $duration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_duration_delete', methods: ['POST'])]
    public function delete(Request $request, Duration $duration, DurationRepository $durationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$duration->getId(), $request->request->get('_token'))) {
            $durationRepository->remove($duration, true);
        }

        return $this->redirectToRoute('app_duration_index', [], Response::HTTP_SEE_OTHER);
    }
}
