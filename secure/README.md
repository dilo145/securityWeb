# Application Sécurisée

Ce projet est une application sécurisée, conçue pour illustrer les bonnes pratiques de développement en matière de sécurité web.

## Prérequis
Avant de commencer, assurez-vous d’avoir les éléments suivants installés :
- Docker

## Installation

Pour configurer et lancer l’application, suivez les étapes ci-dessous :
1. Démarrez les services Docker en exécutant la commande suivante dans le répertoire racine du projet :
```bash
docker compose up -d
```
2. Une fois les conteneurs démarrés, accédez au conteneur secure-symfony-php-1 avec cette commande :
```bash
docker exec -it secure-symfony-php-1 bash
```
3. À l’intérieur du conteneur, exécutez les commandes suivantes pour installer les dépendances et configurer le projet :
```bash
composer i
npm ci
php bin/console d:d:c
php bin/console d:s:u -f
npm run watch
```
ou exécutez toutes les commandes en une seule :
```bash
composer i && npm ci && php bin/console d:d:c && php bin/console d:s:u -f && npm run watch
``` 

4. L’application est désormais prête à être utilisée. Accédez à l’interface web via :
- Application principale : http://localhost
- phpMyAdmin : http://localhost:8080
- Mailcatcher : http://localhost:1080

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