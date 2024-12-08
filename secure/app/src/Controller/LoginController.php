<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Psr\Log\LoggerInterface;

// secure
class LoginController extends AbstractController
 {
     #[Route('/login', name: 'app_login')]
     public function index(AuthenticationUtils $authenticationUtils, LoggerInterface $logger): Response
     {
         // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();
         if ($error) {
             $logger->error('Login error: ' . $error->getMessage());
         }
         $lastUsername = $authenticationUtils->getLastUsername();

         // Pass the reCAPTCHA public key to the template
         $recaptchaPublicKey = $this->getParameter('recaptcha_public_key');

         return $this->render('login/index.html.twig', [
             'last_username' => $lastUsername,
             'error' => $error,
             'recaptcha_public_key' => $recaptchaPublicKey,
         ]);
     }
 }