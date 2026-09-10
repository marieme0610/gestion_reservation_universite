<?php

namespace App\Controller;

use App\Service\SalleService;
use App\Validation\SalleValidator;
use App\DTO\CreerSalleBuilder;
use App\Rendering\ResponseRendererInterface;

class SalleController extends AbstractController
{
    public function __construct(
        private SalleService $salleService,
        private SalleValidator $validator,
        ResponseRendererInterface $renderer
    ) {
        parent::__construct($renderer);
    }

    public function index(): void
    {
        $criteres = [
            'nom'           => trim($_GET['nom'] ?? ''),
            'type_salle_id' => $_GET['type_salle_id'] ?? '',
        ];
        $page = max(1, (int) ($_GET['page'] ?? 1));

        $pagination = $this->salleService->rechercherEtPaginer($criteres, $page, 5);

        $this->renderView('salle/index', [
            'title'      => 'Liste des salles',
            'salles'     => $pagination->items,
            'pagination' => $pagination,
            'criteres'   => $criteres,
            'types'      => $this->salleService->listerTypes(),
        ]);
    }

    public function show(int $id): void
    {
        $salle = $this->salleService->trouver($id);

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
            'types'  => $this->salleService->listerTypes(),
            'errors' => $errors,
            'old'    => $old
        ]);
    }

    public function store(): void
    {
        $data = [
            'nom'           => trim($_POST['nom'] ?? ''),
            'batiment'      => trim($_POST['batiment'] ?? ''),
            'capacite'      => (int) ($_POST['capacite'] ?? 0),
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

        $this->salleService->creer($dto);

        $_SESSION['success'] = "Salle enregistrée avec succès !";
        $this->redirect('/salles');
    }

    public function edit(int $id): void
    {
        $salle = $this->salleService->trouver($id);

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
            'types' => $this->salleService->listerTypes(),
            'salle' => $salle,
            'errors' => $errors,
            'old' => $old,
        ]);
    }

    public function update(int $id): void
    {
        $salle = $this->salleService->trouver($id);
        if (!$salle) {
            http_response_code(404);
            $this->renderView('error/404');
            return;
        }

        $data = [
            'nom' => trim($_POST['nom'] ?? ''),
            'batiment' => trim($_POST['batiment'] ?? ''),
            'capacite' => (int) ($_POST['capacite'] ?? 0),
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

        $this->salleService->modifier($salle, $dto);
        $this->redirect('/salles');
    }
}