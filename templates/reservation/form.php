<?php

/** @var array $salles */ ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h1 class="h4 mb-0 text-primary">Réserver une salle</h1>
            </div>
            <div class="card-body">
                <form action="/reservations/creer" method="POST" novalidate>

                    <!-- Choix de la Salle -->
                    <div class="mb-3">
                        <label for="salle_id" class="form-label">Salle <span class="text-danger">*</span></label>
                        <select name="salle_id" id="salle_id" class="form-select <?= isset($errors['salle_id']) ? 'is-invalid' : '' ?>">
                            <option value="">-- Sélectionner une salle --</option>
                            <?php foreach ($salles as $salle): ?>
                                <option value="<?= e($salle->id) ?>" <?= (isset($old['salle_id']) && $old['salle_id'] == $salle->id) ? 'selected' : '' ?>>
                                    <?= e($salle->nom) ?> (Bâtiment <?= e($salle->batiment) ?> - Capacité: <?= e($salle->capacite) ?> pers.)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['salle_id'])): ?>
                            <div class="invalid-feedback"><?= e($errors['salle_id']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <!-- Responsable -->
                        <div class="col-md-6 mb-3">
                            <label for="responsable" class="form-label">Nom du responsable <span class="text-danger">*</span></label>
                            <input type="text" name="responsable" id="responsable" class="form-control <?= isset($errors['responsable']) ? 'is-invalid' : '' ?>" value="<?= e($old['responsable'] ?? '') ?>">
                            <?php if (isset($errors['responsable'])): ?>
                                <div class="invalid-feedback"><?= e($errors['responsable']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Adresse Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" value="<?= e($old['email'] ?? '') ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= e($errors['email']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Début -->
                        <div class="col-md-6 mb-3">
                            <label for="date_debut" class="form-label">Début <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="date_debut" id="date_debut" class="form-control <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>" value="<?= e($old['date_debut'] ?? '') ?>">
                            <?php if (isset($errors['date_debut'])): ?>
                                <div class="invalid-feedback"><?= e($errors['date_debut']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Fin -->
                        <div class="col-md-6 mb-3">
                            <label for="date_fin" class="form-label">Fin <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="date_fin" id="date_fin" class="form-control <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>" value="<?= e($old['date_fin'] ?? '') ?>">
                            <?php if (isset($errors['date_fin'])): ?>
                                <div class="invalid-feedback"><?= e($errors['date_fin']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Motif -->
                    <div class="mb-4">
                        <label for="motif" class="form-label">Motif <span class="text-danger">*</span></label>
                        <textarea name="motif" id="motif" rows="3" class="form-control <?= isset($errors['motif']) ? 'is-invalid' : '' ?>"><?= e($old['motif'] ?? '') ?></textarea>
                        <?php if (isset($errors['motif'])): ?>
                            <div class="invalid-feedback"><?= e($errors['motif']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/reservations" class="btn btn-outline-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Confirmer la réservation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>