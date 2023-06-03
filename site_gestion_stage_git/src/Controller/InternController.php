<?php

namespace App\Controller;

use App\Entity\Intern;
use App\Form\InternType;
use App\Repository\ApplicationRepository;
use App\Repository\InternRepository;
use App\Repository\UserRepository;
use App\Services\ImageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/intern')]
class InternController extends AbstractController
{
    #[Route('/', name: 'app_intern_index', methods: ['GET'])]
    public function index(InternRepository $internRepository, ApplicationRepository $applicationRepository): Response
    {
        return $this->render('intern/index.html.twig', [
            'interns' => $internRepository->findAll(),
            'applications' => $applicationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_intern_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InternRepository $internRepository, UserRepository $userRepository, ImageManager $imageManager): Response
    {
        //recuperer l'utilisateur 
        $user=$this->getUser();

        $intern = new Intern();
        $form = $this->createForm(InternType::class, $intern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // import fichier image
            $imageManager->EnregistreImage($form, 'avatar', $intern, 'avatar_par_defaut.webp');
            // 
            $intern->setUser($user);
           
            $internRepository->save($intern, true);
            $user->setCompleteData(true);
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_my_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('intern/new.html.twig', [
            'intern' => $intern,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_intern_show', methods: ['GET'])]
    public function show(Intern $intern): Response
    {
        return $this->render('intern/show.html.twig', [
            'intern' => $intern,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_intern_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Intern $intern, InternRepository $internRepository): Response
    {
        $form = $this->createForm(InternType::class, $intern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $internRepository->save($intern, true);

            return $this->redirectToRoute('app_intern_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('intern/edit.html.twig', [
            'intern' => $intern,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_intern_delete', methods: ['POST'])]
    public function delete(Request $request, Intern $intern, InternRepository $internRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$intern->getId(), $request->request->get('_token'))) {
            $internRepository->remove($intern, true);
        }

        return $this->redirectToRoute('app_intern_index', [], Response::HTTP_SEE_OTHER);
    }
}
