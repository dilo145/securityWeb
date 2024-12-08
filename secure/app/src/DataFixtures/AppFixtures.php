<?php

namespace App\DataFixtures;

use App\Entity\Lycee;
use App\Entity\Reponse;
use App\Entity\Ressource;
use App\Entity\Salle;
use App\Entity\Secteur;
use App\Entity\Section;
use App\Entity\Question;
use App\Entity\Metier;
use App\Entity\Competence;
use App\Entity\Activite;
use App\Entity\Atelier;
use App\Entity\User;
use App\Entity\Inscription;
use App\Entity\Questionnaire;
use App\Entity\Session;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Create Lycee
        for ($i = 0; $i < 10; $i++) {
            $lycee = new Lycee();
            $lycee->setNom($faker->company);
            $manager->persist($lycee);
        }

        // Create Section
        for ($i = 0; $i < 10; $i++) {
            $section = new Section();
            $section->setNom($faker->word);
            $manager->persist($section);
        }

        // Create Secteur
        $secteurs = [];
        for ($i = 0; $i < 10; $i++) {
            $secteur = new Secteur();
            $secteur->setNom($faker->word);
            $secteur->setDescription($faker->paragraph);
            $manager->persist($secteur);
            $secteurs[] = $secteur;
        }

        // Create Salle
        $salles = [];
        for ($i = 0; $i < 10; $i++) {
            $salle = new Salle();
            $salle->setNom($faker->word);
            $salle->setEtage($faker->word);
            $salle->setCapaciteMaximum($faker->numberBetween(20, 100));
            $manager->persist($salle);
            $salles[] = $salle;
        }

        // Create Ressource
        $ressources = [];
        for ($i = 0; $i < 10; $i++) {
            $ressource = new Ressource();
            $ressource->setType($faker->word);
            $ressource->setContenu($faker->paragraph);
            $manager->persist($ressource);
            $ressources[] = $ressource;
        }

        // Create Reponse
        $reponses = [];
        for ($i = 0; $i < 10; $i++) {
            $reponse = new Reponse();
            $reponse->setNom($faker->word);
            $manager->persist($reponse);
            $reponses[] = $reponse;
        }

        // Create Competence
        $competences = [];
        for ($i = 0; $i < 10; $i++) {
            $competence = new Competence();
            $competence->setNom($faker->word);
            $manager->persist($competence);
            $competences[] = $competence;
        }

        // Create Activite
        $activites = [];
        for ($i = 0; $i < 10; $i++) {
            $activite = new Activite();
            $activite->setNom($faker->word);
            $manager->persist($activite);
            $activites[] = $activite;
        }

        // Create Metier and link it with Competence and Activite
        $metiers = [];
        for ($i = 0; $i < 10; $i++) {
            $metier = new Metier();
            $metier->setNom($faker->word);
            $metier->addCompetence($competences[array_rand($competences)]);
            $metier->addActivite($activites[array_rand($activites)]);
            $manager->persist($metier);
            $metiers[] = $metier;
        }

        // Create Atelier and link it with Secteur, Metier, Ressource, and Salle
        $ateliers = [];
        for ($i = 0; $i < 10; $i++) {
            $atelier = new Atelier();
            $atelier->setNom($faker->word);
            $atelier->setSecteur($secteurs[array_rand($secteurs)]);
            $atelier->setIntervenant($faker->name);
            $atelier->setDateDebut($faker->dateTimeBetween('-1 month', 'now'));
            $atelier->setDateFin($faker->dateTimeBetween('now', '+1 month'));
            $atelier->addMetier($metiers[array_rand($metiers)]);
            $atelier->addRessource($ressources[array_rand($ressources)]);
            $atelier->addSalle($salles[array_rand($salles)]);

            $manager->persist($atelier);
            $ateliers[] = $atelier;
        }

        // Create User entities for specific roles
        $roles = ['ROLE_STUDENT', 'ROLE_SCHOOL', 'ROLE_ADMIN'];
        $userEmails = [
            'student@example.com',
            'school@example.com',
            'admin@example.com'
        ];

        foreach ($userEmails as $index => $email) {
            $user = new User();
            $user->setEmail($email);
            $user->setRoles([$roles[$index]]);
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            $user->setIsVerified(true);

            // Create and link Inscription (optional)
            $inscription = new Inscription();
            $inscription->setUser($user);
            $inscription->setTelephone($faker->phoneNumber);
            $inscription->setNom($faker->name);
            $inscription->setPrenom($faker->firstName);
            $manager->persist($inscription);
            $user->setInscription($inscription);

            $manager->persist($user);
        }

        // Create User and link it with Inscription
        $users = [];
        $inscriptions = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->unique()->safeEmail);
            $user->setRoles(['ROLE_USER']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            $user->setIsVerified(true);

            // Create and link Inscription
            $inscription = new Inscription();
            $inscription->setUser($user);
            $inscription->setTelephone($faker->phoneNumber);
            $inscription->setNom($faker->name);
            $inscription->setPrenom($faker->firstName);
            $manager->persist($inscription);
            $user->setInscription($inscription);

            $manager->persist($user);
            $users[] = $user;
            $inscriptions[] = $inscription;
        }

        // Create Questionnaire and link it with a Question and Inscription
        for ($i = 0; $i < 10; $i++) {
            $questionnaire = new Questionnaire();
            $questionnaire->setEdition($faker->numberBetween(1, 10));
            $questionnaire->setType($faker->word);
            $questionnaire->setReponse($faker->paragraph);
// to fix
//          $questionnaire->setQuestion($questions[array_rand($questions)]);
//          $questionnaire->setInscrit($inscription);

            $manager->persist($questionnaire);
        }

        // Create Session and link it with Atelier and Inscription
//        for ($i = 0; $i < 3; $i++) {
//            $session = new Session();
//            $session->setAtelier($ateliers[array_rand($ateliers)]);
//            $session->setInscription($inscriptions[array_rand($inscriptions)]);
//
//            $manager->persist($session);
//        }

        $manager->flush();
    }
}
