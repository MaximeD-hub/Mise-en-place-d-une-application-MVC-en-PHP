<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <!-- Header -->
    <header class="app-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="/"><?= APP_NAME ?></a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <!-- Utilisateur connecté -->
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <!-- Menu Admin -->
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin">Tableau de bord</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/users">Utilisateurs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/trajets">Trajets</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/agences">Agences</a>
                                </li>
                            <?php else: ?>
                                <!-- Menu Utilisateur -->
                                <li class="nav-item">
                                    <a class="btn btn-success me-2" href="/trajet/create">
                                        + Proposer un trajet
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <li class="nav-item">
                                <span class="nav-link text-light">
                                    <?= htmlspecialchars($_SESSION['user_prenom'] . ' ' . $_SESSION['user_nom']) ?>
                                </span>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-outline-light btn-sm" href="/logout">Déconnexion</a>
                            </li>
                        <?php else: ?>
                            <!-- Utilisateur non connecté -->
                            <li class="nav-item">
                                <a class="btn btn-outline-light" href="/login">Connexion</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Contenu principal -->
    <main class="main-content">
        <div class="container">
            <!-- Messages flash -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['errors']['general'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['errors']['general']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['errors']['general']); ?>
            <?php endif; ?>