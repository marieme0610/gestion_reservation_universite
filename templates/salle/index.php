<?php
/** @var array $salles */
/** @var \App\Support\PaginationResult $pagination */
/** @var array $criteres */
/** @var array $types */
$criteresActifs = array_filter($criteres, fn($v) => $v !== '');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Salles de cours</h1>
        <p class="text-muted mb-0">Toutes les salles disponibles pour réservation.</p>
    </div>
    <a href="/salles/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nouvelle salle
    </a>
</div>

<form method="GET" action="/salles" class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" value="<?= e($criteres['nom'] ?? '') ?>">
            </div>
            <div class="col-md-5">
                <label class="form-label">Type</label>
                <select name="type_salle_id" class="form-select">
                    <option value="">Tous</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?= e($type->id) ?>" <?= (string) ($criteres['type_salle_id'] ?? '') === (string) $type->id ? 'selected' : '' ?>>
                            <?= e($type->nom) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100" title="Rechercher">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
        <?php if ($criteresActifs): ?>
            <a href="/salles" class="btn btn-sm btn-outline-secondary mt-3">
                <i class="bi bi-x-circle me-1"></i>Réinitialiser les filtres
            </a>
        <?php endif; ?>
    </div>
</form>

<?php if (empty($salles)): ?>
    <div class="card">
        <div class="empty-state">
            <i class="bi bi-door-closed"></i>
            <p class="mb-3"><?= $criteresActifs ? 'Aucune salle ne correspond à ces critères.' : 'Aucune salle enregistrée pour le moment.' ?></p>
            <a href="/salles/create" class="btn btn-primary btn-sm">Créer une salle</a>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($salles as $salle): ?>
            <div class="col-md-4 mb-4">
                <div class="card card-hover h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0"><?= e($salle->nom) ?></h5>
                            <?php if ($salle->active): ?>
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Active</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Inactive</span>
                            <?php endif; ?>
                        </div>
                        <h6 class="card-subtitle mb-3 text-muted">
                            <i class="bi bi-geo-alt me-1"></i>Bâtiment <?= e($salle->batiment) ?>
                        </h6>
                        <p class="card-text mb-0">
                            <i class="bi bi-people me-1 text-primary"></i>
                            <strong><?= e($salle->capacite) ?></strong> personnes
                        </p>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                        <a href="/salles/<?= e($salle->id) ?>" class="btn btn-sm btn-outline-primary">Détails</a>
                        <a href="/salles/<?= e($salle->id) ?>/edit" class="btn btn-sm btn-outline-secondary">Modifier</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($pagination->totalPages() > 1): ?>
    <nav aria-label="Pagination des salles" class="mt-3">
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