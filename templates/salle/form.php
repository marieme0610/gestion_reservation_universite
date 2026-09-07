<?php
$types = $types ?? [];
$errors = $errors ?? [];
$old = $old ?? [];
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h1 class="h4 mb-0"><?= isset($salle) ? 'Modifier la salle' : 'Créer une salle' ?></h1>
            </div>
            <div class="card-body">
                <form action="<?= isset($salle) ? "/salles/{$salle->id}/edit" : '/salles' ?>" method="POST">
                    <div class="mb-3">
                        <label for="type_salle_id" class="form-label">Type de salle</label>
                        <select name="type_salle_id" id="type_salle_id" class="form-select <?= isset($errors['type_salle_id']) ? 'is-invalid' : '' ?>">
                            <option value="">-- Sélectionner un type --</option>
                            <?php foreach ($types as $type): ?>
                                <option value="<?= e($type->id) ?>" <?= (string)($old['type_salle_id'] ?? $salle->type_salle_id ?? '') === (string)$type->id ? 'selected' : '' ?>><?= e($type->nom) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['type_salle_id'])): ?>
                            <div class="invalid-feedback"><?= e($errors['type_salle_id']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nom de la salle</label>
                        <input type="text" name="nom" class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>" value="<?= e($old['nom'] ?? $salle->nom ?? '') ?>">
                        <?php if (isset($errors['nom'])): ?>
                            <div class="invalid-feedback"><?= e($errors['nom']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bâtiment</label>
                        <input type="text" name="batiment" class="form-control <?= isset($errors['batiment']) ? 'is-invalid' : '' ?>" value="<?= e($old['batiment'] ?? $salle->batiment ?? '') ?>">
                        <?php if (isset($errors['batiment'])): ?>
                            <div class="invalid-feedback"><?= e($errors['batiment']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Capacité</label>
                        <input type="number" name="capacite" class="form-control <?= isset($errors['capacite']) ? 'is-invalid' : '' ?>" value="<?= e($old['capacite'] ?? $salle->capacite ?? '') ?>">
                        <?php if (isset($errors['capacite'])): ?>
                            <div class="invalid-feedback"><?= e($errors['capacite']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" name="active" id="active" class="form-check-input" <?= (!isset($salle) || $salle->active) ? 'checked' : '' ?>>
                        <label for="active" class="form-check-label">Salle active</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>