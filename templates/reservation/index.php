<?php
/** @var array $reservations */
/** @var \App\Support\PaginationResult $pagination */
/** @var array $criteres */
/** @var array $salles */
$statutBadges = [
    1 => ['label' => 'Confirmée', 'class' => 'bg-success', 'icon' => 'bi-check-circle'],
    2 => ['label' => 'Annulée',   'class' => 'bg-secondary', 'icon' => 'bi-x-circle'],
];
$criteresActifs = array_filter($criteres, fn($v) => $v !== '');
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

<form method="GET" action="/reservations" class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label">Salle</label>
                <select name="salle_id" class="form-select">
                    <option value="">Toutes</option>
                    <?php foreach ($salles as $salle): ?>
                        <option value="<?= e($salle->id) ?>" <?= (string) ($criteres['salle_id'] ?? '') === (string) $salle->id ? 'selected' : '' ?>>
                            <?= e($salle->nom) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Statut</label>
                <select name="statut_reservation_id" class="form-select">
                    <option value="">Tous</option>
                    <option value="1" <?= ($criteres['statut_reservation_id'] ?? '') === '1' ? 'selected' : '' ?>>Confirmée</option>
                    <option value="2" <?= ($criteres['statut_reservation_id'] ?? '') === '2' ? 'selected' : '' ?>>Annulée</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100" title="Rechercher">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
        <?php if ($criteresActifs): ?>
            <a href="/reservations" class="btn btn-sm btn-outline-secondary mt-3">
                <i class="bi bi-x-circle me-1"></i>Réinitialiser les filtres
            </a>
        <?php endif; ?>
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        <?php if (empty($reservations)): ?>
            <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
                <p class="mb-3"><?= $criteresActifs ? 'Aucune réservation ne correspond à ces critères.' : 'Aucune réservation enregistrée pour le moment.' ?></p>
                <a href="/reservations/create" class="btn btn-primary btn-sm">Créer une réservation</a>
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

<?php if ($pagination->totalPages() > 1): ?>
    <nav aria-label="Pagination des réservations" class="mt-3">
        <ul class="pagination justify-content-center mb-0">
            <li class="page-item <?= !$pagination->aPagePrecedente() ? 'disabled' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($criteresActifs, ['page' => $pagination->page - 1])) ?>">Précédent</a>
            </li>
            <?php for ($p = 1; $p <= $pagination->totalPages(); $p++): ?>
                <li class="page-item <?= $p === $pagination->page ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($criteresActifs, ['page' => $p])) ?>"><?= $p ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= !$pagination->aPageSuivante() ? 'disabled' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($criteresActifs, ['page' => $pagination->page + 1])) ?>">Suivant</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>