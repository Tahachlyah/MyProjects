<?php

namespace App\Controller;

use App\Entity\InternshipOffer;
use App\Entity\InternshipSupervisor;
use App\Form\InternshipOfferType;
use App\Repository\InternshipOfferRepository;
use App\Repository\InternshipSupervisorRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/internship/offer')]
class InternshipOfferController extends AbstractController
{
    #[Route('/', name: 'app_internship_offer_index', methods: ['GET'])]
    public function index(InternshipOfferRepository $internshipOfferRepository): Response
    {
        return $this->render('internship_offer/index.html.twig', [
            'internship_offers' => $internshipOfferRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_internship_offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InternshipOfferRepository $internshipOfferRepository, InternshipSupervisorRepository $internshipSupervisorRepository): Response
    {
        // donne utilisateur connecté
        $user=$this->getUser();
        $internshipSupervisor = $internshipSupervisorRepository->findOneBy(["user"=>$user]);
        $internshipOffer = new InternshipOffer();
        $form = $this->createForm(InternshipOfferType::class, $internshipOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $dateDuJour=new DateTimeImmutable();
            $internshipOffer->setCreateAt($dateDuJour);
            $internshipOffer->setEndDate($dateDuJour); 
            $internshipOffer->setStartDate($dateDuJour);

            $internshipOffer->addInternshipSupervisor($internshipSupervisor);
            $internshipOfferRepository->save($internshipOffer, true);


            return $this->redirectToRoute('app_my_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('internship_offer/new.html.twig', [
            'internship_offer' => $internshipOffer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_internship_offer_show', methods: ['GET'])]
    public function show(InternshipOffer $internshipOffer): Response
    {
        return $this->render('internship_offer/show.html.twig', [
            'internship_offer' => $internshipOffer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_internship_offer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InternshipOffer $internshipOffer, InternshipOfferRepository $internshipOfferRepository): Response
    {
        $form = $this->createForm(InternshipOfferType::class, $internshipOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $internshipOfferRepository->save($internshipOffer, true);

            return $this->redirectToRoute('app_internship_offer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('internship_offer/edit.html.twig', [
            'internship_offer' => $internshipOffer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_internship_offer_delete', methods: ['POST'])]
    public function delete(Request $request, InternshipOffer $internshipOffer, InternshipOfferRepository $internshipOfferRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$internshipOffer->getId(), $request->request->get('_token'))) {
            $internshipOfferRepository->remove($internshipOffer, true);
        }

        return $this->redirectToRoute('app_internship_offer_index', [], Response::HTTP_SEE_OTHER);
    }
}
