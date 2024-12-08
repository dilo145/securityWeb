<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

//unsecure
class LoginController extends AbstractController {
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils, LoggerInterface $logger, Request $request): Response
    {
        // Récupération de l'erreur d'authentification
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error) {
            $logger->error('Login error: ' . $error->getMessage());
        }
        $lastUsername = $authenticationUtils->getLastUsername();

        $title = $request->query->get('title', 'Login');
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'title' => $title,
        ]);
    }
}