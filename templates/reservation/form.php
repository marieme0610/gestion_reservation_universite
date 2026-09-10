<?php
/** @var array $salles */
$errors = $errors ?? [];
$old = $old ?? [];
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3 d-flex align-items-center gap-2">
                <i class="bi bi-calendar-plus text-primary fs-4"></i>
                <h1 class="h4 mb-0">Réserver une salle</h1>
            </div>
            <div class="card-body p-4">
                <form action="/reservations" method="POST" id="reservation-form" novalidate>

                    <div class="mb-3">
                        <label for="salle_id" class="form-label">Salle <span class="text-danger">*</span></label>
                        <select name="salle_id" id="salle_id" class="form-select <?= isset($errors['salle_id']) ? 'is-invalid' : '' ?>" required>
                            <option value="">-- Sélectionner une salle --</option>
                            <?php foreach ($salles as $salle): ?>
                                <option value="<?= e($salle->id) ?>" <?= (isset($old['salle_id']) && (string) $old['salle_id'] === (string) $salle->id) ? 'selected' : '' ?>>
                                    <?= e($salle->nom) ?> — Bâtiment <?= e($salle->batiment) ?> (<?= e($salle->capacite) ?> pers.)<?= !$salle->active ? ' — inactive' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['salle_id'])): ?>
                            <div class="invalid-feedback"><?= e($errors['salle_id']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="responsable" class="form-label">Nom du responsable <span class="text-danger">*</span></label>
                            <input type="text" name="responsable" id="responsable" required
                                class="form-control <?= isset($errors['responsable']) ? 'is-invalid' : '' ?>"
                                value="<?= e($old['responsable'] ?? '') ?>">
                            <?php if (isset($errors['responsable'])): ?>
                                <div class="invalid-feedback"><?= e($errors['responsable']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Adresse email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" required
                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                value="<?= e($old['email'] ?? '') ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= e($errors['email']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_debut" class="form-label">Début <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="date_debut" id="date_debut" required
                                class="form-control <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                                value="<?= e($old['date_debut'] ?? '') ?>">
                            <?php if (isset($errors['date_debut'])): ?>
                                <div class="invalid-feedback"><?= e($errors['date_debut']) ?></div>
                            <?php else: ?>
                                <div class="form-hint mt-1">Doit être dans le futur.</div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date_fin" class="form-label">Fin <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="date_fin" id="date_fin" required
                                class="form-control <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                                value="<?= e($old['date_fin'] ?? '') ?>">
                            <?php if (isset($errors['date_fin'])): ?>
                                <div class="invalid-feedback"><?= e($errors['date_fin']) ?></div>
                            <?php else: ?>
                                <div class="form-hint mt-1">Durée maximale : 4 heures.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div id="duree-warning" class="alert alert-warning d-none d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>Attention : le créneau choisi dépasse 4 heures ou n'est pas valide.</span>
                    </div>

                    <div class="mb-4">
                        <label for="motif" class="form-label">Motif <span class="text-danger">*</span></label>
                        <textarea name="motif" id="motif" rows="3" required
                            class="form-control <?= isset($errors['motif']) ? 'is-invalid' : '' ?>"><?= e($old['motif'] ?? '') ?></textarea>
                        <?php if (isset($errors['motif'])): ?>
                            <div class="invalid-feedback"><?= e($errors['motif']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/reservations" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle me-1"></i>Confirmer la réservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var debutInput = document.getElementById('date_debut');
    var finInput = document.getElementById('date_fin');
    var warning = document.getElementById('duree-warning');

    var now = new Date();
    now.setSeconds(0, 0);
    var minLocal = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
        .toISOString()
        .slice(0, 16);
    debutInput.setAttribute('min', minLocal);

    function checkDuree() {
        if (!debutInput.value || !finInput.value) {
            warning.classList.add('d-none');
            return;
        }
        var debut = new Date(debutInput.value);
        var fin = new Date(finInput.value);
        var dureeMs = fin - debut;
        var invalide = dureeMs <= 0 || dureeMs > 4 * 60 * 60 * 1000;
        warning.classList.toggle('d-none', !invalide);
    }

    debutInput.addEventListener('change', function () {
        finInput.setAttribute('min', debutInput.value);
        checkDuree();
    });
    finInput.addEventListener('change', checkDuree);
})();
</script>