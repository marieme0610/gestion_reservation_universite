<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Liste des Réservations</h1>
    <a href="/reservations/creer" class="btn btn-primary">+ Nouvelle Réservation</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($reservations)): ?>
            <div class="p-4 text-center text-muted">Aucune réservation enregistrée.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Salle</th>
                            <th>Responsable</th>
                            <th>Motif</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th class="text-center">Statut</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <th class="ps-3"><?= e($reservation->id) ?></th>
                                <td><span class="fw-bold"><?= e($reservation->salle->nom ?? 'Salle #' . $reservation->salle_id) ?></span></td>
                                <td>
                                    <div><?= e($reservation->responsable) ?></div>
                                    <small class="text-muted"><?= e($reservation->email) ?></small>
                                </td>
                                <td><?= e($reservation->motif) ?></td>
                                <td><small><?= e((new DateTimeImmutable($reservation->date_debut))->format('d/m/Y H:i')) ?></small></td>
                                <td><small><?= e((new DateTimeImmutable($reservation->date_fin))->format('d/m/Y H:i')) ?></small></td>
                                <td class="text-center">
                                    <?php if ((int)$reservation->statut_reservation_id === 1): ?>
                                        <span class="badge bg-success">Confirmée</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Annulée</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="/reservations/<?= e($reservation->id) ?>" class="btn btn-outline-info">Voir</a>
                                        <?php if ((int)$reservation->statut_reservation_id === 1): ?>
                                            <form action="/reservations/annuler/<?= e($reservation->id) ?>" method="POST" class="d-inline" onsubmit="return confirm('Annuler cette réservation ?');">
                                                <button type="submit" class="btn btn-outline-danger">Annuler</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>