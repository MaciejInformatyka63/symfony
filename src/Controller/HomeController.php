<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use App\Repository\NationaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/home/livres', name: 'app_livre')]
    public function listerLivre(LivreRepository $livreRepository, NationaliteRepository $nationaliteRepository): Response
    {
        $livres = $livreRepository->findLivresAuteurs();
        $nationaliteRepository->findAll();
        return $this->render('home/livres.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('/home/auteurs', name: 'app_auteur')]
    public function listerAuteur(AuteurRepository $auteurRepository, NationaliteRepository $nationaliteRepository): Response
    {
        $auteurs = $auteurRepository->findOrderBy();
        $nationaliteRepository->findAll();
        return $this->render('home/auteurs.html.twig', [
            'auteurs' => $auteurs,
        ]);
    }
}
