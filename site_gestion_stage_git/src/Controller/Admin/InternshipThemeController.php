<?php

namespace App\Controller\Admin;

use App\Entity\InternshipTheme;
use App\Form\InternshipThemeType;
use App\Repository\InternshipThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/internship/theme')]
class InternshipThemeController extends AbstractController
{
    #[Route('/', name: 'app_internship_theme_index', methods: ['GET'])]
    public function index(InternshipThemeRepository $internshipThemeRepository): Response
    {
        return $this->render('internship_theme/index.html.twig', [
            'internship_themes' => $internshipThemeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_internship_theme_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InternshipThemeRepository $internshipThemeRepository): Response
    {
        $internshipTheme = new InternshipTheme();
        $form = $this->createForm(InternshipThemeType::class, $internshipTheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $internshipThemeRepository->save($internshipTheme, true);

            return $this->redirectToRoute('app_internship_theme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('internship_theme/new.html.twig', [
            'internship_theme' => $internshipTheme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_internship_theme_show', methods: ['GET'])]
    public function show(InternshipTheme $internshipTheme): Response
    {
        return $this->render('internship_theme/show.html.twig', [
            'internship_theme' => $internshipTheme,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_internship_theme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InternshipTheme $internshipTheme, InternshipThemeRepository $internshipThemeRepository): Response
    {
        $form = $this->createForm(InternshipThemeType::class, $internshipTheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $internshipThemeRepository->save($internshipTheme, true);

            return $this->redirectToRoute('app_internship_theme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('internship_theme/edit.html.twig', [
            'internship_theme' => $internshipTheme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_internship_theme_delete', methods: ['POST'])]
    public function delete(Request $request, InternshipTheme $internshipTheme, InternshipThemeRepository $internshipThemeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$internshipTheme->getId(), $request->request->get('_token'))) {
            $internshipThemeRepository->remove($internshipTheme, true);
        }

        return $this->redirectToRoute('app_internship_theme_index', [], Response::HTTP_SEE_OTHER);
    }
}
