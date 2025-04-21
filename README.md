# Système de Gestion de Bibliothèque - Backend

Ce projet est le backend d'un système de gestion de bibliothèque développé avec Symfony.

## Description

Ce système permet de gérer:
- Les ouvrages et leurs exemplaires
- Les auteurs
- Les utilisateurs
- Les prêts de livres
- Les rayons et classifications
- Les mots-clés

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- PostgreSQL 16
- Symfony CLI (recommandé)

## Installation

1. Cloner le dépôt
```bash
git clone [URL_DU_REPO]
cd gestionBibliothequeGroupe3_backend
```

2. Installer les dépendances
```bash
composer install
```

3. Configurer la base de données dans le fichier `.env`
```
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
```

4. Créer la base de données
```bash
php bin/console doctrine:database:create
```

5. Appliquer les migrations
```bash
php bin/console doctrine:migrations:migrate
```

6. (Optionnel) Charger les fixtures
```bash
php bin/console doctrine:fixtures:load
```

## Démarrage

Lancer le serveur de développement:
```bash
symfony server:start
```

Ou avec PHP:
```bash
php -S localhost:8000 -t public/
```

## Structure du projet

- `src/Controller/` - Contrôleurs de l'application
- `src/Entity/` - Entités Doctrine (modèles de données)
- `src/Repository/` - Repositories pour l'accès aux données
- `src/DataFixtures/` - Jeux de données pour le développement

## API Endpoints

### Ouvrages
- `GET /api/ouvrages` - Liste tous les ouvrages
- `POST /api/ouvrages` - Ajoute un nouvel ouvrage
- `GET /api/ouvrages/{id}` - Récupère un ouvrage par son ID
- `PUT /api/ouvrages/{id}` - Met à jour un ouvrage

### Auteurs
- `GET /api/auteurs` - Liste tous les auteurs
- `POST /api/auteurs` - Ajoute un nouvel auteur
- `GET /api/auteurs/{id}` - Récupère un auteur par son ID
- `PUT /api/auteurs/{id}` - Met à jour un auteur

### Prêts
- `GET /api/prets` - Liste tous les prêts
- `POST /api/prets` - Enregistre un nouveau prêt
- `GET /api/prets/{id}` - Récupère un prêt par son ID
- `PUT /api/prets/{id}` - Met à jour un prêt

### Utilisateurs
- `GET /api/users` - Liste tous les utilisateurs
- `POST /api/users` - Ajoute un nouvel utilisateur
- `GET /api/users/{id}` - Récupère un utilisateur par son ID
- `PUT /api/users/{id}` - Met à jour un utilisateur

## Contributeurs

- Équipe 3

## Licence

Ce projet est sous licence [insérer type de licence] 