# Changelog

Toutes les modifications notables de ce projet sont documentées dans ce fichier.

## [1.6.0] - 2026-09-10

### Ajouté

- Workflow GitHub Actions (`docker-publish.yml`) qui construit et publie automatiquement une image Docker sur GitHub Container Registry (GHCR) à chaque tag Git poussé (`vX.Y.Z`).
- Déclenchement manuel du workflow (`workflow_dispatch`) avec un paramètre `ref`, permettant de reconstruire l'image d'un tag historique.
- Script `scripts/build-images-per-tag.sh` : reconstruit et publie une image pour chaque tag Git possédant un `Dockerfile` (à partir de v1.3.0), en utilisant `git worktree` pour isoler chaque build sans affecter le dossier de travail courant.

## [1.5.0] - 2026-09-10

### Ajouté

- Nouveau design system (variables CSS, police Inter, icônes Bootstrap Icons).
- Navbar avec dégradé et mise en évidence du lien actif selon la page courante.
- Indices contextuels dans le formulaire de réservation (durée maximale, date future) et avertissement JavaScript non bloquant en cas de créneau invalide.
- États vides avec appel à l'action sur les listes de salles et réservations.

### Modifié

- Pages d'erreur 404/405/500 restylées avec icônes, cohérentes avec le reste de l'application.
- Format d'affichage des dates harmonisé entre la liste et le détail d'une réservation.

## [1.4.0] - 2026-09-10

### Ajouté

- `ReservationFactory` et `SalleFactory` : centralisent la construction des entités Eloquent, séparée des règles métier (Service) et du cycle HTTP (Contrôleur).

### Modifié

- `CreerReservationBuilder` et `CreerSalleBuilder` (pattern Builder), définis depuis l'origine du projet mais jamais utilisés, sont désormais réellement appelés dans les contrôleurs.
- `CreerReservationService` ne construit plus directement l'entité `Reservation` : délègue à `ReservationFactory`.
- `SalleController::store()` et `update()` utilisent Builder + Factory au lieu d'un remplissage direct (`fill()`).

## [1.3.0] - 2026-09-10

### Ajouté

- Conteneurisation complète de l'application : `Dockerfile` basé sur `php:8.3-cli` (sans serveur web, serveur de développement PHP intégré en commande de démarrage).
- `docker-compose.yml` : services `app`, `db` (MySQL 8.0) et `phpmyadmin`, réseau et volume dédiés.
- Externalisation de tous les identifiants sensibles via un fichier `.env` (non commité) et `.env.docker.example` comme modèle.

### Corrigé

- Port de connexion MySQL corrigé (`3307` → `3306`) qui empêchait la connexion entre les conteneurs `app` et `db`.
- Extension PHP `pdo_mysql` manquante dans le `Dockerfile`, provoquant l'erreur `could not find driver`.
- Ajout de `.phpunit.result.cache` au `.gitignore`.

## [1.2.0] - 2026-09-09

### Ajouté

- Nouvelle exception `ReservationInvalideException` pour les règles métier non liées à la disponibilité d'une salle (date de fin avant début, durée supérieure à 4h, date dans le passé, salle introuvable).

### Corrigé

- Ces règles métier affichent désormais leur message réel à l'utilisateur, au lieu d'un message générique qui masquait la cause exacte du rejet.
- `ReservationController::index()` lit enfin `$_SESSION['errors']` : le message d'échec d'annulation d'une réservation, jusque-là invisible, s'affiche correctement.
- Les pages d'erreur 404 et 405 passent désormais par le layout commun (navbar, CSS), au lieu d'être affichées comme du HTML brut non stylé.
- Champ `motif` rendu réellement obligatoire dans la validation, cohérent avec l'astérisque du formulaire.
- Correction de la casse du cast `dateTime` → `datetime` dans le modèle `Reservation` : ce bug faisait échouer toute assignation de date sur une réservation (`Call to undefined method DateTime::set()`), invisible jusqu'ici faute de suite de tests exécutée.

## [1.1.0] - 2026-09-09

### Corrigé

- Suppression en cascade remplacée par une restriction (`onDelete: restrict`) sur les clés étrangères `salles.type_salle_id`, `reservations.salle_id` et `reservations.statut_reservation_id`, pour empêcher la suppression silencieuse de données liées.
- Contrainte d'unicité ajoutée sur `salles.nom` pour empêcher la création de deux salles portant le même nom.

### Supprimé

- Fichier `test_validation.php` (script de débogage vide, laissé par erreur dans le dépôt).

## [1.0.0] - 2026-09-07

### Ajouté

- Finalisation de l'application.

## [0.12.0] - 2026-09-07

### Ajouté

- Suite de tests (unitaires et d'intégration).

## [0.11.0] - 2026-09-07

### Ajouté

- Conteneur d'injection de dépendances (PHP-DI).

## [0.10.0] - 2026-09-07

### Ajouté

- Routage HTTP avec FastRoute.

## [0.9.0] - 2026-09-06

### Ajouté

- Contrôleurs et vues.

## [0.8.0] - 2026-09-06

### Ajouté

- Implémentation des règles métier (couche Service).

## [0.7.0] - 2026-09-06

### Ajouté

- Accès aux données via une interface de repository.

## [0.6.1] - 2026-09-07

### Modifié

- Refactoring de l'architecture des DTO (pattern Builder, `ValidationException`).

## [0.6.0] - 2026-09-06

### Ajouté

- Objets de transfert de données (DTO).

## [0.5.0] - 2026-09-06

### Ajouté

- Validation des données avec 3 classes de validation, pattern Strategy via `ValidatorInterface`.

## [0.4.1] - 2026-09-07

### Modifié

- Séparation des migrations par table et ajout du script CLI `marieme`.

## [0.4.0] - 2026-09-06

### Ajouté

- Données initiales (seeders).

## [0.3.0] - 2026-09-06

### Ajouté

- Modèles Eloquent.

## [0.2.0] - 2026-09-06

### Ajouté

- Configuration d'Eloquent dans le fichier bootstrap.

## [0.1.0] - 2026-09-06

### Ajouté

- Initialisation du projet PHP (Composer, autoloading).

## [0.0.0] - 2026-09-06

### Ajouté

- Premier commit.
