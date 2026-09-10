<?php
/** @var object $salle */
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white d-flex align-items-center gap-2">
                <i class="bi bi-door-open text-primary fs-4"></i>
                <h1 class="h4 mb-0"><?= e($salle->nom) ?></h1>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted">Bâtiment</dt>
                    <dd class="col-sm-8"><?= e($salle->batiment) ?></dd>

                    <dt class="col-sm-4 text-muted">Capacité</dt>
                    <dd class="col-sm-8"><?= e($salle->capacite) ?> places</dd>

                    <dt class="col-sm-4 text-muted">Statut</dt>
                    <dd class="col-sm-8">
                        <?php if ($salle->active): ?>
                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                        <?php else: ?>
                            <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Indisponible</span>
                        <?php endif; ?>
                    </dd>
                </dl>
            </div>
            <div class="card-footer bg-white d-flex justify-content-between">
                <a href="/salles" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Retour aux salles
                </a>
                <a href="/salles/<?= e($salle->id) ?>/edit" class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i>Modifier
                </a>
            </div>
        </div>
    </div>
</div>