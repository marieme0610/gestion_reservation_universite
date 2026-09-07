<?php

namespace App\Controller;

use App\DTO\CreerReservationDTO;
use App\Service\CreerReservationService;
use App\Service\AnnulerReservationService;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Validation\ReservationValidator;
use App\Exception\SalleIndisponibleException;
use App\Exception\ReservationIntrouvableException;
use Exception;

class ReservationController extends AbstractController
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private SalleRepositoryInterface $salleRepository,
        private CreerReservationService $creerReservationService,
        private AnnulerReservationService $annulerReservationService,
        private ReservationValidator $validator
    ) {}

    public function index(): void
    {
        $reservations = $this->reservationRepository->getAllReservation();

        $this->renderView('reservation/index', [
            'title'        => 'Liste des réservations',
            'reservations' => $reservations
        ]);
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationRepository->findReservation($id);

        if (!$reservation) {
            http_response_code(404);
            $this->renderView('error/404');
            return;
        }

        $this->renderView('reservation/show', [
            'title'       => "Réservation #{$id}",
            'reservation' => $reservation
        ]);
    }

    public function create(): void
    {
        $salles = $this->salleRepository->getAllSalle();
        $errors = $_SESSION['errors'] ?? [];
        $old    = $_SESSION['old'] ?? [];

        unset($_SESSION['errors'], $_SESSION['old']);

        $this->renderView('reservation/form', [
            'title'  => 'Nouvelle réservation',
            'salles' => $salles,
            'errors' => $errors,
            'old'    => $old
        ]);
    }

    public function store(): void
    {
        $data = [
            'salle_id'    => $_POST['salle_id'] ?? null,
            'responsable' => trim($_POST['responsable'] ?? ''),
            'email'       => trim($_POST['email'] ?? ''),
            'motif'       => trim($_POST['motif'] ?? ''),
            'date_debut'  => $_POST['date_debut'] ?? '',
            'date_fin'    => $_POST['date_fin'] ?? ''
        ];

        $validationResult = $this->validator->validate($data);
        if (!$validationResult->isValid()) {
            $_SESSION['errors'] = $validationResult->errors();
            $_SESSION['old']    = $data;
            $this->redirect('/reservations/create');
        }

        try {
            $dto = CreerReservationDTO::fromArray($this->validator, $data);
            $reservationId = $this->creerReservationService->creatReservation($dto);

            $_SESSION['success'] = "Réservation #{$reservationId} créée avec succès !";
            $this->redirect('/reservations');
        } catch (SalleIndisponibleException $e) {
            $_SESSION['errors']['globale'] = $e->getMessage();
            $_SESSION['old'] = $data;
            $this->redirect('/reservations/create');
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['errors']['globale'] = 'Une erreur est survenue lors de la réservation.';
            $_SESSION['old'] = $data;
            $this->redirect('/reservations/create');
        }
    }

    public function cancel(int $id): void
    {
        try {
            $this->annulerReservationService->annuler($id);
            $_SESSION['success'] = "La réservation #{$id} a été annulée avec succès.";
        } catch (ReservationIntrouvableException $e) {
            $_SESSION['errors']['globale'] = $e->getMessage();
        }

        $this->redirect('/reservations');
    }
}
