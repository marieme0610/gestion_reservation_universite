<?php

namespace App\Controller;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;
use App\Model\TypeSalle;
use App\Repository\SalleRepositoryInterface;
use App\Validation\SalleValidator;
use App\DTO\CreerSalleBuilder;
use App\Factory\SalleFactory;

class SalleController extends AbstractController
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private SalleValidator $validator
    ) {}

    public function index(): void
    {
        $salles = $this->salleRepository->getAllSalle();

        $this->renderView('salle/index', [
            'title'  => 'Liste des salles',
            'salles' => $salles
        ]);
    }

    public function show(int $id): void
    {
        $salle = $this->salleRepository->findSalle($id);

        if (!$salle) {
            http_response_code(404);
            $this->renderView('error/404');
            return;
        }

        $this->renderView('salle/show', [
            'title' => "Détails de la salle {$salle->nom}",
            'salle' => $salle
        ]);
    }

    public function create(): void
    {
        $errors = $_SESSION['errors'] ?? [];
        $old    = $_SESSION['old'] ?? [];

        unset($_SESSION['errors'], $_SESSION['old']);

        $this->renderView('salle/form', [
            'title'  => 'Créer une salle',
            'types'  => TypeSalle::all(),
            'errors' => $errors,
            'old'    => $old
        ]);
    }

    public function store(): void
    {
        $data = [
            'nom'           => trim($_POST['nom'] ?? ''),
            'batiment'      => trim($_POST['batiment'] ?? ''),
            'capacite'      => (int)($_POST['capacite'] ?? 0),
            'active'        => isset($_POST['active']),
            'type_salle_id' => $_POST['type_salle_id'] ?? null
        ];

        $validationResult = $this->validator->validate($data);
        if (!$validationResult->isValid()) {
            $_SESSION['errors'] = $validationResult->errors();
            $_SESSION['old']    = $data;
            $this->redirect('/salles/create');
        }

                $dto = CreerSalleBuilder::create()
            ->nom($data['nom'])
            ->batiment($data['batiment'])
            ->capacite($data['capacite'])
            ->active($data['active'])
            ->typeSalleId($data['type_salle_id'])
            ->build($this->validator);

        $salle = SalleFactory::creerDepuisDTO($dto);
        $this->salleRepository->saveSalle($salle);

        $_SESSION['success'] = "Salle enregistrée avec succès !";
        $this->redirect('/salles');
    }

    public function edit(int $id): void
    {
        $salle = $this->salleRepository->findSalle($id);

        if (!$salle) {
            http_response_code(404);
            $this->renderView('error/404');
            return;
        }

        $errors = $_SESSION['errors'] ?? [];
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['errors'], $_SESSION['old']);

        $this->renderView('salle/form', [
            'title' => "Modifier la salle {$salle->nom}",
            'types' => TypeSalle::all(),
            'salle' => $salle,
            'errors' => $errors,
            'old' => $old,
        ]);
    }

    public function update(int $id): void
    {
        $salle = $this->salleRepository->findSalle($id);
        if (!$salle) {
            http_response_code(404);
            $this->renderView('error/404');
            return;
        }

        $data = [
            'nom' => trim($_POST['nom'] ?? ''),
            'batiment' => trim($_POST['batiment'] ?? ''),
            'capacite' => (int)($_POST['capacite'] ?? 0),
            'active' => isset($_POST['active']),
            'type_salle_id' => $_POST['type_salle_id'] ?? null,
        ];

        $validationResult = $this->validator->validate($data);
        if (!$validationResult->isValid()) {
            $_SESSION['errors'] = $validationResult->errors();
            $_SESSION['old'] = $data;
            $this->redirect("/salles/{$id}/edit");
        }

                $dto = CreerSalleBuilder::create()
            ->nom($data['nom'])
            ->batiment($data['batiment'])
            ->capacite($data['capacite'])
            ->active($data['active'])
            ->typeSalleId($data['type_salle_id'])
            ->build($this->validator);

        SalleFactory::remplirDepuisDTO($salle, $dto);
        $this->salleRepository->saveSalle($salle);
        $this->redirect('/salles');
    }
}
