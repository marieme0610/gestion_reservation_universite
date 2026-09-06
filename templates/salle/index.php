<?php

/** @var array $salles */ ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Salles de cours</h1>
    <a href="/salles/creer" class="btn btn-success">+ Nouvelle Salle</a>
</div>

<div class="row">
    <?php foreach ($salles as $salle): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= e($salle->nom) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Bâtiment <?= e($salle->batiment) ?></h6>
                    <p class="card-text">Capacité : <strong><?= e($salle->capacite) ?></strong> personnes</p>
                    <div>
                        Statut :
                        <?php if ($salle->active): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inactive</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                    <a href="/salles/<?= e($salle->id) ?>" class="btn btn-sm btn-outline-primary">Détails</a>
                    <a href="/salles/modifier/<?= e($salle->id) ?>" class="btn btn-sm btn-outline-secondary">Modifier</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>