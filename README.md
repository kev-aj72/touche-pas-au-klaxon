# Touche pas au klaxon

Application web de covoiturage destinée aux employés d’une entreprise possédant plusieurs agences.

## Fonctionnalités

### Visiteur non connecté

- Consulter les trajets futurs ayant encore des places disponibles.
- Consulter les trajets par ordre de départ croissant.
- Accéder au formulaire de connexion.

### Employé connecté

- Consulter les informations détaillées d’un trajet.
- Afficher les coordonnées de l’auteur dans une fenêtre modale.
- Proposer un nouveau trajet.
- Modifier ses propres trajets.
- Supprimer ses propres trajets.
- Se déconnecter.

### Administrateur

- Consulter la liste des employés.
- Consulter la liste des agences.
- Créer, modifier et supprimer une agence.
- Consulter tous les trajets.
- Supprimer n’importe quel trajet.
- Créer et gérer ses propres trajets.

Les employés proviennent du système des ressources humaines. Leur création, leur modification et leur suppression ne sont donc pas proposées dans l’application.

## Technologies utilisées

- PHP 8.2
- Architecture MVC
- MySQL ou MariaDB
- PDO
- Composer
- Routeur `izniburak/router`
- Dotenv
- Bootstrap 5
- Sass
- PHPStan
- PHPUnit

## Prérequis

Avant l’installation, les éléments suivants doivent être disponibles :

- XAMPP avec Apache et MySQL/MariaDB ;
- PHP 8.2 ou supérieur ;
- Composer ;
- Node.js et npm ;
- Git.

## Installation

### 1. Récupérer le projet

Dans le dossier `C:\xampp\htdocs`, exécuter dans le terminal :

```powershell
git clone https://github.com/kev-aj72/touche-pas-au-klaxon.git
cd touche-pas-au-klaxon
```

### 2. Installer les dépendances PHP

```powershell
composer install
```

### 3. Installer les dépendances front-end

```powershell
npm install
```

### 4. Compiler le fichier Sass

```powershell
npm run sass
```

## Configuration de l’environnement

Créer un fichier nommé `.env` à la racine du projet.

Ajouter le contenu suivant :

```dotenv
APP_ENV=development
APP_DEBUG=true

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=touche_pas_au_klaxon
DB_USER=root
DB_PASSWORD=

APP_BASE_PATH=/touche-pas-au-klaxon/public
```

Pour un environnement de production, utiliser :

```dotenv
APP_ENV=production
APP_DEBUG=false
```

## Installation de la base de données

1. Démarrer Apache et MySQL depuis le panneau de contrôle XAMPP.
2. Ouvrir [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Sélectionner l’onglet `Importer`.
4. Importer d’abord le fichier `Database/1-database.sql`.
5. Importer ensuite le fichier `Database/2-donnees.sql`.

Le premier fichier crée la base de données et ses tables. Le second ajoute les agences, les employés et les trajets de démonstration.

## Lancement de l’application

Démarrer Apache et MySQL depuis XAMPP, puis ouvrir :

[http://localhost/touche-pas-au-klaxon/public/](http://localhost/touche-pas-au-klaxon/public/)

## Comptes de démonstration

### Administrateur

```text
Adresse email : john.doe@email.fr
Mot de passe : Admin-password
```

### Utilisateur

```text
Adresse email : alexandre.martin@email.fr
Mot de passe : User-Password
```

## Sécurité

L’application utilise plusieurs protections :

- mots de passe enregistrés avec un hachage sécurisé ;
- requêtes préparées avec PDO ;
- protection CSRF des formulaires effectuant des opérations d’écriture ;
- protection des données affichées contre les injections HTML ;
- contrôle des rôles utilisateur et administrateur ;
- vérification de l’auteur avant la modification ou la suppression d’un trajet ;
- limitation des tentatives de connexion ;
- messages d’erreur détaillés uniquement en mode développement.

## Contrôles métier

Lors de la création ou de la modification d’un trajet :

- les agences de départ et d’arrivée doivent être différentes ;
- les agences sélectionnées doivent exister ;
- le départ doit être prévu dans le futur ;
- l’arrivée doit être postérieure au départ ;
- le nombre total de places doit être supérieur à zéro ;
- le nombre de places disponibles ne peut pas dépasser le nombre total.

## Vérification du code avec PHPStan

Le projet est vérifié avec PHPStan au niveau 5.

```powershell
& "C:\xampp\php\php.exe" ".\vendor\bin\phpstan" analyse
```

## Tests

Les tests PHPUnit couvriront les opérations d’écriture dans la base de données.