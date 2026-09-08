Dans un document ARCHITECTURE.md, les étudiants devront identifier et expliquer :

MVC ;

1. classes concernées : Les sous-dossiers Models/ (Salle, Reservation), Controllers/ (SalleController), et les vues dans views/ ou templates/.

2. Rôle :

    Model : Gère la logique métier, la structure et la persistance des données.

    View : Gère la présentation et l'affichage de l'interface utilisateur.

    Controller : Reçoit les requêtes HTTP, interagit avec le Modèle pour récupérer ou modifier les données, puis sélectionne la Vue à afficher.

3. Avantage : Séparation stricte des responsabilités (découplage), ce qui facilite le travail en équipe (un développeur front-end et un développeur back-end peuvent travailler en parallèle) et la réutilisation du code.

4. Limite / Risque : Risque d'avoir des contrôleurs trop volumineux (Fat Controllers) si la logique métier n'est pas correctement déplacée dans des Services ou des Repositories.

5. Extrait du projet :

```php
 public function index(): void
    {
        $reservations = $this->reservationRepository->getAllReservation();

        $this->renderView('reservation/index', [
            'title'        => 'Liste des réservations',
            'reservations' => $reservations
        ]);
    }
```
*Front Controller* ;

1. classes concernées :
--le fichier index.php qui se trouve dans le dossier public
 
2. Rôle :
--Le Front controller c'est le point d'acces de l'appliqué toute requette passe par lui c'est réceptionner des requêtes; 

3. Avantage:
-- Sa nous permet d'avoir un seul point d'entrer sa vas facilité la gestion de la securité car on aura qu'a securisé cette partie;

4. Limite ou Risque:
--Si le script index.php ou sa configuration contient une erreur critique, toute l'application devient indisponible.
 ;
5. Extrait  du projet.

```php
 <?php

 use App\Application;
 use DI\ContainerBuilder;

 require dirname(__DIR__) . '/vendor/autoload.php';
 ...
```

Router ;

1. classes concernées :

--le fichier web.php qui se trouve dans le dossier routes
 
2. Rôle :

Le Routeur c'est lui qui analyse l'URI et la methode de la requette permettant de savoir  quel controller et action appellé c'est lui qui gere la résolution des URL

3. Avantage:
-- Sa nous permet de gerer les routes ;

4. Limite ou Risque:
-- ?
 ;
5. Extrait  du projet.

```php
return function (RouteCollector $r) {

    $r->addRoute('GET', '/', [SalleController::class, 'index']);

    $r->addRoute('GET', '/salles', [SalleController::class, 'index']);}
 ```  

**Validator**

1. classes concernées :

--le fichier ReservationValidator.php et SalleValidator.php qui se trouve dans le dossier Validation
 
2. Rôle :

Le validator quand ta lui il validé les donnee il verifie si les donnee sont conforme est ce qu'il respect les regle pour etre traité

3. Avantage:
-- Sa nous permet d'avoir des données conforme garantie l'intégrité des données en entrée et protection contre l'injection de données invalides ou malveillantes. 

4. Limite ou Risque:
-- ?
 ;
5. Extrait  du projet.

```php

$rules = [
  'salle_id' => v::key('salle_id', v::intVal()->positive(), true),
  'responsable' => v::key('responsable', v::stringType()->length(2, 120), true)]

```
 ;



**DTO**

1. classes concernées :

--le fichier CreerReservationDTO.php et CreerSalleDTO.php qui se trouve dans le dossier DTO
 
2. Rôle :

Les DTO qui signifie Data Transfere Object c'est un transport de donnee c'est lui qui nous donne les format des donnee qu'a besoin la vue on l'utiliser dans le controller se sont les donnee qu'on doit donnee au vue ou les donnee qu'on recupere du view ,il transporte les données structurées et typées entre les couches de l'application (par exemple du Contrôleur vers le Service).

3. Avantage:
-- Sa nous permet d'avoir des données dont la vue a besoin et assure l'immuabilité ;

4. Limite ou Risque:
-- ?
 ;
5. Extrait  du projet.

```php

readonly class CreerSalleDTO
{
    private function __construct(
        public string $nom,
        public string $batiment,
        public int $capacite,
        public bool $active,
        public int $typeSalleId
    ) {}
}
```
 ;


**ORM** ;


1. classes concernées :

--le fichier Reservation.php et Salle.php qui se trouve dans le dossier Model
 
2. Rôle :

Faire le pont entre la base de données et le code orienté objet  en traduisant les tables en classes et les lignes de tables en instances d'objets.

3. Avantage:

-- Évite d'écrire des requêtes SQL manuelles.

4. Limite ou Risque:
--Quand on a une requette complexe il ne peut pas s'en charger oubien il sera oblig" de les  ?
 ;
5. Extrait  du projet.

```php

class Reservation extends Model{
    protected $table = 'reservations';

    protected $fillable = [
        'salle_id' ,
        'statut_reservation_id' ,
        'responsable' ,
        'email' ,
        'motif' ,
        'date_debut',
        'date_fin' 
    ]
}
```

**Active Record** ;

1. classes concernées :

--le fichier SalleRepository.php et ReservationRepository.php qui se trouve dans le dossier Repository
 
2. Rôle :

--Active Record est un design pattern où une classe de modèle représente une table SQL ET contient les méthodes de persistance directes (save(), delete(), find()).Associer directement la logique métier et l'accès aux données dans la même classe
 
3. Avantage:
-- Très simple et rapide à prendre en main pour créer, lire, mettre à jour et supprimer des enregistrements (CRUD).;

4. Limite ou Risque:
--Viole le principe de responsabilité unique (SRP), car le modèle gère à la fois l'état métier et la persistance en base de données.
 ;
5. Extrait  du projet.

```php

$salle = Salle::find(1);
$salle->active = true;
$salle->save();

```

**Repository** ;

1. classes concernées :

--le fichier ReservationValidator.php et SalleValidator.php qui se trouve dans le dossier Repository
 
2. Rôle :

--Le Repository c'est le composant qui isole la logique d'accès aux données qui communique avec la base donnee il peut y acceder pour recuperer des donnee oubien y inserer pour persister les donnees

 
3. Avantage: 

-- Découple le code métier permettant de respect le SRP;

4. Limite ou Risque:
--?
 ;
5. Extrait  du projet.

```php

 public function saveReservation(Reservation $reservation):int{
        $reservation->save();
        return (int)$reservation->id;
    }

```

**Service** ;

1. classes concernées :

--le fichier CreerReservationService.php et AnnulationReservationService.php qui se trouve dans le dossier Service
 
2. Rôle :

--Le Service qu'en a lui gere tout ce qui est logique metier c'est a dire tout ce qui est calcule et consort


 
3. Avantage: 

-- Rend la logique métier réutilisable;

4. Limite ou Risque:
--?
 ;
5. Extrait  du projet.

```php

$newReservation->date_debut = $debut->format('Y-m-d H:i:s');
        $newReservation->date_fin = $fin->format('Y-m-d H:i:s');

        return $this->reservationRepository->saveReservation($newReservation);

```

**injection par constructeur** 


1. classes concernées :

--le fichier CreerReservationService.php et AnnulationReservationService.php qui se trouve dans le dossier Service
 
2. Rôle :

--L'injection par constructeur veut dir qu'on injecte des object dans le constructur d'un classe car il en a besoin pour fonctionné

 3. Avantage: 

-- Donne a la classe sa dependance;

4. Limite ou Risque:
--?
 ;
5. Extrait  du projet.

```php

 public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private ReservationRepositoryInterface $reservationRepository
    ) {}


```
**conteneur d’injection** ;

1. classes concernées :

--le fichier Container.php  qui se trouve dans le dossier Config
 
2. Rôle :

--Le conteneur d'injection de dependance c'est lui qui instancie les objet et scan chaque classe pour voir ce quil a besoin puis le lui donne

 3. Avantage: 

-- Centralise l'instanciation des objets et permet d'associer une interface à une implémentation concrète de manière globale;

4. Limite ou Risque:
--?
 ;
5. Extrait  du projet.

```php


    CreerReservationService::class => autowire(),
    AnnulerReservationService::class => autowire(),


```

 

**autowiring** 


1. classes concernées :

--le fichier Container.php  qui se trouve dans le dossier Config
 
2. Rôle :

--L'autowiring c'est une methode dans fastRouter qui permet de deviner l'objet dont la classe a besoin et de le lui injecter a travers la ReflexionClass qui permet de scaner la classe et de voir ce quil a besoin il peut acceder au constructeur du classe a travers la methode getConstructor et au parametttre a travers la fonction getParams

 3. Avantage: 

-- Gain de temps considérable lors de l'écriture du code, évite d'avoir à déclarer manuellement chaque service dans un fichier de configuration.

4. Limite ou Risque:
--?
 ;
5. Extrait  du projet.

```php


    CreerReservationService::class => autowire(),
    AnnulerReservationService::class => autowire(),


```


**inversion de contrôle** 

L'inversion de controlle c'est le fait qu'un object ne doit pas connaitre comment est creer l'objet dont il doit utiliser on doit le lui donnee sans pour autant qu'il sache comment on la creer car c'est pas de sa responsabilité


1. classes concernées :

--le fichier Container.php  qui se trouve dans le dossier Config
 
2. Rôle :

--Déléguer la gestion du flux d'exécution et de la création des objets à un conteneur/framework plutôt qu'à la classe elle-même

 3. Avantage: 

-- Réduction forte du couplage entre les composants de l'application

4. Limite ou Risque:
--?
 ;
5. Extrait  du projet.

```php

 public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private ReservationRepositoryInterface $reservationRepository
    ) {}nnulerReservationService::class => autowire(),

```

les cinq principes SOLID.

SOLID on commence par le :

S => qui signifie Single Responsibility Principle. chaque classe entité doit avoir une seul responsabilité et sa facilite la maintenance;

O => qui signifie Open and Close c'est le principe qui veut dire fermé a la modification et ouvert a l'evolution sa nous interdit de modifie du code deja fonctionnel et cela permet d'ajouter de nouvelles fonctionnalités (par héritage ou composition) sans toucher au code existant déjà testé et validé.


L => qui signifie Liscov Subsitition ce principe stipule qu'une classe fille doit pouvoir remplacer sa classe mère n'importe où sans altérer le bon fonctionnement du programme. Si une classe enfant modifie ou casse le comportement attendu de la classe parent (ex: lever une exception inattendue), elle viole le principe de Liskov.

I => qui signifie la Interface Segregation qui est la ségrégation des interfaces signifie qu'aucune classe ne doit être forcée de dépendre de méthodes qu'elle n'utilise pas. Il vaut donc mieux créer plusieurs petites interfaces spécifiques plutôt qu'une seule grande interface "fourre-tout".

D => qui signifie Dependance Inversion qui est le principe de l'inversion de dependance une classe métier ne doit jamais manipuler directement une classe d'infrastructure concrète. Elle doit interagir avec une interface qui définit le contrat. Ainsi, changer d'outil (par exemple passer de MySQL à PostgreSQL, ou de SwiftMailer à PHPMailer) n'impacte pas le code métier.



