# Application Vulnérable

Ce projet est une application conçue pour démontrer des vulnérabilités courantes dans un environnement web.

## Prérequis
Avant de commencer, assurez-vous d’avoir les éléments suivants installés :
- Docker

## Installation

Pour configurer et lancer l’application, suivez les étapes ci-dessous :
1. Démarrez les services Docker en exécutant la commande suivante dans le répertoire racine du projet :
```bash
docker compose up -d
```
2. Une fois les conteneurs démarrés, accédez au conteneur vulnerable-symfony-php-1 avec cette commande :
```bash
docker exec -it vulnerable-symfony-php-1 bash
```
3. À l’intérieur du conteneur, exécutez les commandes suivantes pour installer les dépendances et configurer le projet :
```bash
composer i
npm ci
npm run watch
```
ou exécutez toutes les commandes en une seule :
```bash
composer i && npm ci && php bin/console d:d:c && php bin/console d:s:u -f && npm run watch
```     

4. L’application est désormais prête à être utilisée. Accédez à l’interface web via :
- Application principale : http://localhost:8081
- phpMyAdmin : http://localhost:8082
- Mailcatcher : http://localhost:1081

## Utilisation
Voici les comptes utilisateurs pré-configurés dans l’application, avec leurs rôles associés :

- Utilisateur étudiant
  - Email : student@example.com
  - Rôle : ROLE_STUDENT

- Utilisateur école
  - Email : school@example.com
  - Rôle : ROLE_SCHOOL

- Administrateur
  - Email : admin@example.com
  - Rôle : ROLE_ADMIN

Ces comptes peuvent être utilisés pour tester différentes fonctionnalités de l'application en fonction des rôles attribués à chaque utilisateur.