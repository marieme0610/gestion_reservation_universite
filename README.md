**Questions Étape 1 — Initialiser le projet Composer**

1. ​Quel est le rôle de Composer ?
* Composer est le gestionnaire de dépendances officiel pour PHP. Il ne se contente pas de les rassembler : il télécharge, met à jour et installe les bibliothèques tierces dont votre projet a besoin, tout en gérant automatiquement le chargement automatique des classes (autoloading).

2. ​Quelle différence existe entre require et require-dev ?

* require : Contient les dépendances indispensables au fonctionnement du projet en production (ex. un ORM comme Doctrine, un framework comme Symfony, un client HTTP).

* require-dev : Contient les outils nécessaires uniquement durant le développement ou les tests (ex. PHPUnit pour les tests unitaires, PHP_CodeSniffer pour le style de code). 
Ces paquets ne sont pas installés sur le serveur de production lorsqu'on exécute la commande composer install --no-dev.

 3. ​ Pourquoi faut-il versionner composer.lock ?
* Le fichier composer.lock gèle (lock) les versions exactes de toutes les dépendances (et sous-dépendances) installées à un instant $T$. Le versionner garantit que tous les développeurs de l'équipe ainsi que le serveur de production utilisent strictement le même environnement de code, évitant le problème du ça marche sur ma machine mais pas en prod.

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



    **Questions Créer les modèles**
    
    1. ​ Quel type de relation Eloquent avez-vous utilisé ?

J'ai utilisé deux types de relations Eloquent :

    belongsTo (Un-à-Un / Plusieurs-à-Un) dans Salle (vers TypeSalle) et dans Reservation (vers Salle et StatutReservation), car la clé étrangère se trouve dans ces tables.

    hasMany (Un-à-Plusieurs) dans TypeSalle, StatutReservation et Salle (vers Reservation), car un enregistrement parent peut être lié à plusieurs enregistrements enfants.

2. ​ Pourquoi déclarer $fillable ou $guarded ?
On déclare $fillable (ou $guarded) par mesure de sécurité contre les failles d'assignation en masse (Mass Assignment). $fillable sert de liste blanche : il autorise uniquement les attributs spécifiés à être remplis lors d'une création ou mise à jour via un tableau (ex: Salle::create($donnees)), empêchant un utilisateur de modifier des champs sensibles non autorisés.

Alors que $fillable fonctionne comme une liste blanche, $guarded fonctionne comme une liste noire. On l'utilise pour spécifier uniquement les attributs qui sont strictement interdits d'être remplis lors d'une assignation en masse (Mass Assignment). Tous les autres attributs absents de cette liste seront alors autorisés par défaut.


3. ​ Pourquoi convertir active en booléen ?
En base de données, la colonne active est stockée sous forme d'entier (TINYINT 0 ou 1). Le cast 'active' => 'boolean' permet à Eloquent de la convertir automatiquement en un véritable booléen PHP (true ou false). Cela simplifie les conditions logiques dans le code (ex: if ($salle->active)) et garantit le typage strict.

4. ​ Pourquoi convertir les dates en objets ?
Les dates sont récupérées depuis la base de données sous forme de chaînes de caractères (string). En les castant en 'datetime', Eloquent les transforme automatiquement en objets Carbon / DateTime. Cela permet d'effectuer facilement des opérations avancées sur les dates (comparaisons, ajouts de jours, formatage d'affichage) sans devoir les parser manuellement.


Questions
1. ​ Quelle différence existe entre migration et seeder ?

Migration : Définit et modifie la structure (le schéma) de la BDD (création/modification de tables, colonnes, clés étrangères).

Seeding : Remplit la BDD avec du contenu (données de test ou données initiales indispensables comme les rôles, types de salles, statuts).

2. ​ Pourquoi les données initiales doivent-elles être reproductibles ?

Dire que les données doivent être reproductibles, cela veut dire que n'importe quel développeur (ou vous-même sur un nouveau PC ou sur le serveur de production) doit pouvoir reconstruire exactement la même base de données avec le même jeu de données en une seule commande (ex: php database/seed.php).

Les raisons principales :

    Travail en équipe : Tous les développeurs du projet travaillent avec les mêmes données de test (mêmes IDs, mêmes types de salles).

    Environnement de test fiable : Les tests automatiques ou manuels donnent toujours le même résultat car ils partent du même état initial.

    Déploiement facile : Quand le projet passe en production, on peut générer automatiquement les données de base obligatoires (ex: les statuts Confirmée, En attente) sans devoir les ressaisir à la main dans PhpMyAdmin.

3. ​ Comment empêcher les doublons ?

Au niveau PHP / ORM (Applicatif) :
En utilisant firstOrCreate(['nom' => 'Amphithéâtre']). Eloquent vérifie d'abord si la ligne existe en BDD avant de l'insérer.

Au niveau de la BDD (Structure) :
En ajoutant la contrainte ->unique() sur la colonne dans la migration (ex: $table->string('code')->unique();), ce qui empêche techniquement MySQL d'accepter deux fois la même valeur.