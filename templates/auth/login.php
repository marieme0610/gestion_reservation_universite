<?php
$errors = $errors ?? [];
?>

<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white py-3 d-flex align-items-center gap-2">
                <i class="bi bi-box-arrow-in-right text-primary fs-4"></i>
                <h1 class="h4 mb-0">Connexion</h1>
            </div>
            <div class="card-body p-4">
                <form action="/login" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" required class="form-control" autofocus>
                    </div>
                    <div class="mb-4">
                        <label for="mot_de_passe" class="form-label">Mot de passe</label>
                        <input type="password" name="mot_de_passe" id="mot_de_passe" required class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>