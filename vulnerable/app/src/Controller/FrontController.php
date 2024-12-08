<?php

namespace App\Controller;

use App\Repository\AtelierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'homepage')]

    public function index(): Response
    {

        return $this->render('front/index.html.twig', [
        ]);
    }

    #[Route('/all-ateliers', name: 'all-articles')]

    public function allAteliers(AtelierRepository $atelierRepository): Response
    {
        $ateliers = $atelierRepository->findAll();

        return $this->render('front/all-articles.html.twig', [
            'ateliers' => $ateliers,
        ]);

    }

    // création d'une route pour appeler le name dans un path
    #[Route('/logout', name: 'logout')]

    public function logout()
    {
        // Le contrôleur peut rester vide, car c'est le firewall de Symfony qui gère la déconnexion
        throw new \RuntimeException('This should never be reached!');
    }
}
