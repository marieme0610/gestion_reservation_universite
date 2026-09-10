<?php
$types = $types ?? [];
$errors = $errors ?? [];
$old = $old ?? [];

$isChecked = array_key_exists('active', $old)
    ? (bool) $old['active']
    : (isset($salle) ? (bool) $salle->active : true);
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white d-flex align-items-center gap-2">
                <i class="bi bi-door-open text-primary fs-4"></i>
                <h1 class="h4 mb-0"><?= isset($salle) ? 'Modifier la salle' : 'Créer une salle' ?></h1>
            </div>
            <div class="card-body p-4">
                <form action="<?= isset($salle) ? "/salles/{$salle->id}/edit" : '/salles' ?>" method="POST">
                    <div class="mb-3">
                        <label for="type_salle_id" class="form-label">Type de salle <span class="text-danger">*</span></label>
                        <select name="type_salle_id" id="type_salle_id" required
                            class="form-select <?= isset($errors['type_salle_id']) ? 'is-invalid' : '' ?>">
                            <option value="">-- Sélectionner un type --</option>
                            <?php foreach ($types as $type): ?>
                                <option value="<?= e($type->id) ?>" <?= (string) ($old['type_salle_id'] ?? $salle->type_salle_id ?? '') === (string) $type->id ? 'selected' : '' ?>>
                                    <?= e($type->nom) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['type_salle_id'])): ?>
                            <div class="invalid-feedback"><?= e($errors['type_salle_id']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nom de la salle <span class="text-danger">*</span></label>
                        <input type="text" name="nom" required
                            class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>"
                            value="<?= e($old['nom'] ?? $salle->nom ?? '') ?>">
                        <?php if (isset($errors['nom'])): ?>
                            <div class="invalid-feedback"><?= e($errors['nom']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bâtiment <span class="text-danger">*</span></label>
                        <input type="text" name="batiment" required
                            class="form-control <?= isset($errors['batiment']) ? 'is-invalid' : '' ?>"
                            value="<?= e($old['batiment'] ?? $salle->batiment ?? '') ?>">
                        <?php if (isset($errors['batiment'])): ?>
                            <div class="invalid-feedback"><?= e($errors['batiment']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Capacité <span class="text-danger">*</span></label>
                        <input type="number" name="capacite" min="1" required
                            class="form-control <?= isset($errors['capacite']) ? 'is-invalid' : '' ?>"
                            value="<?= e($old['capacite'] ?? $salle->capacite ?? '') ?>">
                        <?php if (isset($errors['capacite'])): ?>
                            <div class="invalid-feedback"><?= e($errors['capacite']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input type="checkbox" name="active" id="active" class="form-check-input" <?= $isChecked ? 'checked' : '' ?>>
                        <label for="active" class="form-check-label">Salle active (réservable)</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check2-circle me-1"></i>Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>