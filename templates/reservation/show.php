<?php

/** @var object $reservation */ ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">Réservation #<?= e($reservation->id) ?></h1>
                <?php if ((int)$reservation->statut_reservation_id === 1): ?>
                    <span class="badge bg-success">Confirmée</span>
                <?php else: ?>
                    <span class="badge bg-secondary">Annulée</span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Responsable :</dt>
                    <dd class="col-sm-8"><?= e($reservation->responsable) ?> (<?= e($reservation->email) ?>)</dd>

                    <dt class="col-sm-4">Salle :</dt>
                    <dd class="col-sm-8"><?= e($reservation->salle->nom ?? 'Salle #' . $reservation->salle_id) ?></dd>

                    <dt class="col-sm-4">Motif :</dt>
                    <dd class="col-sm-8"><?= e($reservation->motif) ?></dd>

                    <dt class="col-sm-4">Début :</dt>
                    <dd class="col-sm-8"><?= e($reservation->date_debut) ?></dd>

                    <dt class="col-sm-4">Fin :</dt>
                    <dd class="col-sm-8"><?= e($reservation->date_fin) ?></dd>
                </dl>
            </div>
            <div class="card-footer bg-white text-end">
                <a href="/reservations" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>
    </div>
</div>