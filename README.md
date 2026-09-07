**Questions Étape 1 — Initialiser le projet Composer**

1. ​Quel est le rôle de Composer ?
* Composer est le gestionnaire de dépendances officiel pour PHP. Il ne se contente pas de les rassembler : il télécharge, met à jour et installe les bibliothèques tierces dont votre projet a besoin, tout en gérant automatiquement le chargement automatique des classes (autoloading).

2. ​Quelle différence existe entre require et require-dev ?

* require : Contient les dépendances indispensables au fonctionnement du projet en production (ex. un ORM comme Doctrine, un framework comme Symfony, un client HTTP).

* require-dev : Contient les outils nécessaires uniquement durant le développement ou les tests (ex. PHPUnit pour les tests unitaires, PHP_CodeSniffer pour le style de code). 
Ces paquets ne sont pas installés sur le serveur de production lorsqu'on exécute la commande composer install --no-dev.

 3. ​ Pourquoi faut-il versionner composer.lock ?
* Le fichier composer.lock gèle (lock) les versions exactes de toutes les dépendances (et sous-dépendances) installées à un instant $T$. Le versionner garantit que tous les développeurs de l'équipe ainsi que le serveur de production utilisent strictement le même environnement de code, évitant le problème du "ça marche sur ma machine mais pas en prod".

4. ​Pourquoi ne versionne-t-on pas vendor/ ?
* Poids du dépôt Git : Télécharger des Mo/Go de code tiers alourdit inutilement l'historique du projet.Redondance : Les fichiers composer.json et composer.lock contiennent déjà toutes les instructions nécessaires pour régénérer le dossier vendor/ à l'identique à l'aide d'une simple commande (composer install).


**Questions Configurer Eloquent**

1. Quel rôle joue Capsule\Manager ?

Capsule\Manager (de la classe Illuminate\Database\Capsule\Manager) sert de passerelle et de configurateur pour utiliser l'ORM Eloquent et le Query Builder en dehors du framework Laravel. Il rassemble en un seul endroit la configuration du pilote de base de données (PDO), gère le gestionnaire de connexion et permet de rendre l'instance accessible globalement via des méthodes statiques.
2. Pourquoi Eloquent peut-il fonctionner sans Laravel ?

Eloquent fait partie de la suite d'outils Illuminate, conçue par Laravel de manière découplée et modulaire. Le paquet illuminate/database est une bibliothèque indépendante réutilisable dans n'importe quel projet PHP classique grâce au gestionnaire de dépendances Composer et au chargement automatique des classes (autoload.php).
3. Où doit se trouver le démarrage de l’ORM ?

Le démarrage de l'ORM (bootEloquent()) doit se trouver au tout début du cycle de vie de l'application, dans le fichier d'initialisation global (souvent appelé bootstrap.php ou index.php). Il doit impérativement être exécuté avant le chargement de toute classe métier ou contrôleur qui tente d'interagir avec la base de données.

4. Quelle différence existe entre un ORM et du SQL écrit à la main ?

    Mode de manipulation : Avec du SQL écrit à la main (via PDO par exemple), vous manipulez directement des requêtes sous forme de chaînes de caractères (SELECT * FROM...) et recevez des tableaux bruts. Avec un ORM comme Eloquent, vous manipulez directement des objets PHP (par exemple : $salle->nom = 'Amphi A'; $salle->save();).

    Abstraction et portabilité : Le SQL écrit à la main dépend fortement de la syntaxe spécifique du SGBD utilisé (MySQL, PostgreSQL, SQLite). L'ORM masque ces différences techniques : vous écrivez votre code PHP de la même façon, quel que soit le moteur de base de données configuré.

    Gestion des relations : En SQL pur, il faut écrire soi-même des requêtes avec des jointures (JOIN) parfois longues et complexes. L'ORM simplifie cela en vous permettant de déclarer des méthodes de relation (belongsTo, hasMany) et de les appeler directement sous forme de propriétés (ex. $reservation->salle).

    Productivité et sécurité : L'ORM accélère considérablement le développement en évitant d'écrire des requêtes répétitives et protège nativement contre les injections SQL grâce à la préparation automatique de toutes les requêtes.