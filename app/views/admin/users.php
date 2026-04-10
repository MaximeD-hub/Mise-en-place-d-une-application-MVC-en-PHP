<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Liste des employés</h1>
    <a href="/admin" class="btn btn-secondary">← Retour au tableau de bord</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employes as $employe): ?>
                        <tr>
                            <td><?= $employe['id_employe'] ?></td>
                            <td><?= htmlspecialchars($employe['nom']) ?></td>
                            <td><?= htmlspecialchars($employe['prenom']) ?></td>
                            <td><?= htmlspecialchars($employe['email']) ?></td>
                            <td><?= htmlspecialchars($employe['telephone']) ?></td>
                            <td>
                                <?php if ($employe['role'] === 'admin'): ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-primary">User</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>