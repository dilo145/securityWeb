<?php

//namespace App\Controller;
//
//use App\Repository\AtelierRepository;
//use App\Repository\InscriptionRepository;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//
//class UserProfileController extends AbstractController
//{
//    #[Route('/student/user-profile/{id}', name: 'user-profile')]
//
//    public function index(InscriptionRepository $inscriptionRepository, $id): Response
//    {
//        $inscription = $inscriptionRepository->find($id);
//
//        if (!$inscription) {
//            throw $this->createNotFoundException("L'inscription n'a pas été trouvé.");
//        }
//
//        return $this->render('user-profile/index.html.twig', [
//            'inscription' => $inscription,
//        ]);
//    }
//
//}


namespace App\Controller;


use App\Form\PhotoProfileFormType;
use App\Repository\InscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserProfileController extends AbstractController
{
    #[Route('/student/user-profile/{id}', name: 'user-profile')]
    public function index(Request $request, InscriptionRepository $inscriptionRepository, $id): Response
    {
        $inscription = $inscriptionRepository->find($id);

        if (!$inscription) {
            throw $this->createNotFoundException("L'inscription n'a pas été trouvée.");
        }

        $form = $this->createForm(PhotoProfileFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléversement de la photo.');
                }

                $inscription->setPhoto($newFilename);
                $inscriptionRepository->save($inscription, true);

                $this->addFlash('success', 'Photo de profil mise à jour avec succès.');
            }
        }

        return $this->render('user-profile/index.html.twig', [
            'inscription' => $inscription,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/student/user-profile/{id}/edit', name: 'edit-user-profile')]
    public function editProfile(
        Request               $request,
        InscriptionRepository $inscriptionRepository,
        SluggerInterface      $slugger,
                              $id
    ): Response
    {
        $inscription = $inscriptionRepository->find($id);

        if (!$inscription) {
            throw $this->createNotFoundException("L'inscription n'a pas été trouvée.");
        }

        // Création du formulaire
        $form = $this->createForm(PhotoProfileForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléversement de la photo.');
                }

                $inscription->setPhoto($newFilename);
            }

            $inscriptionRepository->save($inscription, true);

            $this->addFlash('success', 'Photo de profil mise à jour avec succès.');
            return $this->redirectToRoute('user-profile', ['id' => $id]);
        }

        return $this->render('user-profile/edit.html.twig', [
            'form' => $form->createView(),
            'inscription' => $inscription,
        ]);
    }
}


