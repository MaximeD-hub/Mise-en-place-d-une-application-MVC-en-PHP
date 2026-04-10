<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h1 class="mb-4">Tableau de bord administrateur</h1>

<div class="row">
    <!-- Carte Employés -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="dashboard-icon">👥</div>
                <div class="dashboard-number"><?= $stats['nb_employes'] ?></div>
                <div class="dashboard-label">Employés</div>
                <a href="/admin/users" class="btn btn-primary mt-3">Voir la liste</a>
            </div>
        </div>
    </div>

    <!-- Carte Agences -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="dashboard-icon">🏢</div>
                <div class="dashboard-number"><?= $stats['nb_agences'] ?></div>
                <div class="dashboard-label">Agences</div>
                <a href="/admin/agences" class="btn btn-primary mt-3">Gérer</a>
            </div>
        </div>
    </div>

    <!-- Carte Trajets -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="dashboard-icon">🚗</div>
                <div class="dashboard-number"><?= $stats['nb_trajets'] ?></div>
                <div class="dashboard-label">Trajets</div>
                <a href="/admin/trajets" class="btn btn-primary mt-3">Voir tous</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>