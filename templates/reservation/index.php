<?php
/** @var array $reservations */
$statutBadges = [
    1 => ['label' => 'Confirmée', 'class' => 'bg-success', 'icon' => 'bi-check-circle'],
    2 => ['label' => 'Annulée',   'class' => 'bg-secondary', 'icon' => 'bi-x-circle'],
];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Réservations</h1>
        <p class="text-muted mb-0">Toutes les réservations de salles de l'université.</p>
    </div>
    <a href="/reservations/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nouvelle réservation
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <?php if (empty($reservations)): ?>
            <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
                <p class="mb-3">Aucune réservation enregistrée pour le moment.</p>
                <a href="/reservations/create" class="btn btn-primary btn-sm">Créer la première réservation</a>
            </div>
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
                            <?php
                                $statutId = (int) $reservation->statut_reservation_id;
                                $badge = $statutBadges[$statutId] ?? ['label' => 'En attente', 'class' => 'bg-warning text-dark', 'icon' => 'bi-hourglass-split'];
                            ?>
                            <tr>
                                <td class="ps-3 text-muted">#<?= e($reservation->id) ?></td>
                                <td class="fw-semibold"><?= e($reservation->salle->nom ?? 'Salle #' . $reservation->salle_id) ?></td>
                                <td>
                                    <div><?= e($reservation->responsable) ?></div>
                                    <small class="text-muted"><?= e($reservation->email) ?></small>
                                </td>
                                <td><?= e($reservation->motif) ?></td>
                                <td><small><?= e((new DateTimeImmutable($reservation->date_debut))->format('d/m/Y H:i')) ?></small></td>
                                <td><small><?= e((new DateTimeImmutable($reservation->date_fin))->format('d/m/Y H:i')) ?></small></td>
                                <td class="text-center">
                                    <span class="badge <?= $badge['class'] ?>"><i class="bi <?= $badge['icon'] ?> me-1"></i><?= $badge['label'] ?></span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="/reservations/<?= e($reservation->id) ?>" class="btn btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <?php if ($statutId === 1): ?>
                                            <form action="/reservations/<?= e($reservation->id) ?>/cancel" method="POST" class="d-inline" onsubmit="return confirm('Annuler cette réservation ?');">
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
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