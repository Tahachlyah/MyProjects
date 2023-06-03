<?php

namespace App\Controller;

use App\Entity\InternshipSupervisor;
use App\Form\InternshipSupervisorType;
use App\Repository\InternshipSupervisorRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/internship/supervisor')]
class InternshipSupervisorController extends AbstractController
{
    #[Route('/', name: 'app_internship_supervisor_index', methods: ['GET'])]
    public function index(InternshipSupervisorRepository $internshipSupervisorRepository): Response
    {
        return $this->render('internship_supervisor/index.html.twig', [
            'internship_supervisors' => $internshipSupervisorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_internship_supervisor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InternshipSupervisorRepository $internshipSupervisorRepository, UserRepository $userRepository): Response
    {
        // recuperer l'utilisateur 
        $user=$this->getUser();

        $internshipSupervisor = new InternshipSupervisor();
        $form = $this->createForm(InternshipSupervisorType::class, $internshipSupervisor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 
            $internshipSupervisor->setUser($user);

            
            $internshipSupervisorRepository->save($internshipSupervisor, true);
            $user->setCompleteData(true);
            $userRepository->save($user, true);
            return $this->redirectToRoute('app_my_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('internship_supervisor/new.html.twig', [
            'internship_supervisor' => $internshipSupervisor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_internship_supervisor_show', methods: ['GET'])]
    public function show(InternshipSupervisor $internshipSupervisor): Response
    {
        return $this->render('internship_supervisor/show.html.twig', [
            'internship_supervisor' => $internshipSupervisor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_internship_supervisor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InternshipSupervisor $internshipSupervisor, InternshipSupervisorRepository $internshipSupervisorRepository): Response
    {
        $form = $this->createForm(InternshipSupervisorType::class, $internshipSupervisor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $internshipSupervisorRepository->save($internshipSupervisor, true);

            return $this->redirectToRoute('app_internship_supervisor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('internship_supervisor/edit.html.twig', [
            'internship_supervisor' => $internshipSupervisor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_internship_supervisor_delete', methods: ['POST'])]
    public function delete(Request $request, InternshipSupervisor $internshipSupervisor, InternshipSupervisorRepository $internshipSupervisorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$internshipSupervisor->getId(), $request->request->get('_token'))) {
            $internshipSupervisorRepository->remove($internshipSupervisor, true);
        }

        return $this->redirectToRoute('app_internship_supervisor_index', [], Response::HTTP_SEE_OTHER);
    }
}
