<?php

namespace App\Controller;

use App\Repository\AtelierRepository;
use App\Repository\InscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    #[Route('/student/user-profile/{id}', name: 'user-profile')]

    public function index(InscriptionRepository $inscriptionRepository, $id): Response
    {
        $inscription = $inscriptionRepository->find($id);

        if (!$inscription) {
            throw $this->createNotFoundException("L'inscription n'a pas été trouvé.");
        }

        return $this->render('user-profile/index.html.twig', [
            'inscription' => $inscription,
        ]);
    }

}
