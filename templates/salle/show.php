<?php

/** @var object $salle */ ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h1 class="h4 mb-0"><?= e($salle->nom) ?></h1>
            </div>
            <div class="card-body">
                <p><strong>Bâtiment :</strong> <?= e($salle->batiment) ?></p>
                <p><strong>Capacité :</strong> <?= e($salle->capacite) ?> places</p>
                <p><strong>Statut :</strong> <?= $salle->active ? 'Disponible' : 'Indisponible' ?></p>
            </div>
            <div class="card-footer bg-white text-end">
                <a href="/salles" class="btn btn-secondary">Retour aux salles</a>
            </div>
        </div>
    </div>
</div>