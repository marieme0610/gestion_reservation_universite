<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Système de Réservation de Salles') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/salles">Gestion Réservations</a>
            <div class="navbar-nav">
                <a class="nav-link" href="/salles">Salles</a>
                <a class="nav-link" href="/reservations">Réservations</a>
                <a class="nav-link btn btn-outline-light ms-2 text-white" href="/reservations/creer">+ Réserver</a>
            </div>
        </div>
    </nav>

    <main class="container mb-5">
        <!-- Message de succès global -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= e($_SESSION['success']) ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Erreur globale métier (ex: SalleIndisponibleException) -->
        <?php if (!empty($errors['globale'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erreur :</strong> <?= e($errors['globale']) ?>
            </div>
        <?php endif; ?>

        <!-- Injection dynamique du contenu de la vue -->
        <?= $content ?? '' ?>
    </main>

    <footer class="footer mt-auto py-3 bg-white border-top text-center text-muted">
        <div class="container">
            <small>&copy; Université - Tous droits réservés</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>