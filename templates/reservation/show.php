<?php
/** @var object $reservation */
$statutId = (int) $reservation->statut_reservation_id;
$badges = [
    1 => ['label' => 'Confirmée', 'class' => 'bg-success', 'icon' => 'bi-check-circle'],
    2 => ['label' => 'Annulée',   'class' => 'bg-secondary', 'icon' => 'bi-x-circle'],
];
$badge = $badges[$statutId] ?? ['label' => 'En attente', 'class' => 'bg-warning text-dark', 'icon' => 'bi-hourglass-split'];
?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">Réservation #<?= e($reservation->id) ?></h1>
                <span class="badge <?= $badge['class'] ?>"><i class="bi <?= $badge['icon'] ?> me-1"></i><?= $badge['label'] ?></span>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted">Responsable</dt>
                    <dd class="col-sm-8"><?= e($reservation->responsable) ?><br><small class="text-muted"><?= e($reservation->email) ?></small></dd>

                    <dt class="col-sm-4 text-muted">Salle</dt>
                    <dd class="col-sm-8"><?= e($reservation->salle->nom ?? 'Salle #' . $reservation->salle_id) ?></dd>

                    <dt class="col-sm-4 text-muted">Motif</dt>
                    <dd class="col-sm-8"><?= e($reservation->motif) ?></dd>

                    <dt class="col-sm-4 text-muted">Début</dt>
                    <dd class="col-sm-8"><?= e((new DateTimeImmutable($reservation->date_debut))->format('d/m/Y \à H:i')) ?></dd>

                    <dt class="col-sm-4 text-muted">Fin</dt>
                    <dd class="col-sm-8"><?= e((new DateTimeImmutable($reservation->date_fin))->format('d/m/Y \à H:i')) ?></dd>
                </dl>
            </div>
            <div class="card-footer bg-white text-end">
                <a href="/reservations" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>