<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\InternshipOffer;
use App\Repository\ApplicationRepository;
use App\Repository\InternRepository;
use App\Repository\InternshipOfferRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MyAccountController extends AbstractController
{
    #[Route('/my/account', name: 'app_my_account')]
    public function index(InternRepository $internRepository): Response
    {
        return $this->render('my_account/index.html.twig', [
            'intern' => $internRepository->findAll(),
        ]);
    }

    #[Route('/ajouteruneoffre', name: 'user_internship_offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InternshipOfferRepository $internshipOfferRepository): Response
    {
        $internshipOffer = new InternshipOffer();
        $form = $this->createForm(InternshipOfferType::class, $internshipOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $dateDuJour=new DateTimeImmutable();
            $internshipOffer->setCreateAt($dateDuJour);
            $internshipOffer->setEndDate($dateDuJour); 
            $internshipOffer->setStartDate($dateDuJour);

            $internshipOfferRepository->save($internshipOffer, true);


            return $this->redirectToRoute('app_my_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('internship_offer/new.html.twig', [
            'internship_offer' => $internshipOffer,
            'form' => $form,
        ]);
    }

    

}
