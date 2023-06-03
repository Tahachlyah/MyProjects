<?php

namespace App\Controller;
use App\Repository\InternshipOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(InternshipOfferRepository $internshipOfferRepository ): Response
    {
        return $this->render('home/index.html.twig', [
            //  récupérer toutes les offres de stage disponibles et mettre à disposition du template 
            'internship_offers' => $internshipOfferRepository->findAll(),
        ]);
    }
}
