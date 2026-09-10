<?php
/** @var array $salles */
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

<?php if (empty($salles)): ?>
    <div class="card">
        <div class="empty-state">
            <i class="bi bi-door-closed"></i>
            <p class="mb-3">Aucune salle enregistrée pour le moment.</p>
            <a href="/salles/create" class="btn btn-primary btn-sm">Créer la première salle</a>
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