<?php
$errors = $errors ?? [];
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$isActive = static fn(string $prefix): bool =>
    $prefix === '/' ? $currentPath === '/' : str_starts_with($currentPath, $prefix);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Système de Réservation de Salles') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg app-navbar mb-4">
        <div class="container">
            <a class="navbar-brand" href="/salles">
                <span class="brand-icon"><i class="bi bi-building"></i></span>
                Gestion Réservations
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <div class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <a class="nav-link <?= $isActive('/salles') ? 'active' : '' ?>" href="/salles">
                        <i class="bi bi-door-open me-1"></i>Salles
                    </a>
                    <a class="nav-link <?= ($isActive('/reservations') && $currentPath !== '/reservations/create') ? 'active' : '' ?>" href="/reservations">
                        <i class="bi bi-calendar3 me-1"></i>Réservations
                    </a>
                                    <a class="btn btn-brand ms-lg-3" href="/reservations/create">
                    <i class="bi bi-plus-lg me-1"></i>Réserver
                </a>
                <?php if (isset($_SESSION['auth_id'])): ?>
                    <span class="nav-link text-white-50">
                        <i class="bi bi-person-circle me-1"></i><?= e($_SESSION['auth_nom']) ?>
                    </span>
                    <form action="/logout" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-outline-light btn-sm ms-2">Déconnexion</button>
                    </form>
                <?php else: ?>
                    <a class="nav-link" href="/login">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

    <main class="container mb-5">
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div><?= e($_SESSION['success']) ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors['globale'] ?? null)): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div><strong>Erreur :</strong> <?= e($errors['globale']) ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors) && empty($errors['globale'])): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-circle-fill fs-5"></i>
                <div><strong>Veuillez corriger les champs signalés ci-dessous.</strong></div>
            </div>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <footer class="app-footer py-4 text-center">
        <div class="container">
            <small>&copy; <?= date('Y') ?> Université — Gestion des Réservations de Salles</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>