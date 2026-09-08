# Changelog

## [1.1.0] - 2026-09-07

### Ajouté

- Image Docker PHP 8.3 avec Apache, Composer et PDO MySQL.
- Service MySQL 8.0 orchestré avec Docker Compose.
- Réseau Docker dédié et volume persistant pour les données MySQL.
- Healthcheck MySQL et démarrage de l'application après disponibilité de la base.
- Documentation des commandes Docker et de l'initialisation du schéma.

### Corrigé

- Lecture des variables de base de données injectées par l'environnement Docker.
