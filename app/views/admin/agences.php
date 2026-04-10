<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestion des agences</h1>
    <div>
        <a href="/admin/agence/create" class="btn btn-success">+ Créer une agence</a>
        <a href="/admin" class="btn btn-secondary">← Retour</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($agences)): ?>
            <p class="text-muted">Aucune agence enregistrée.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agences as $agence): ?>
                            <tr>
                                <td><?= $agence['id_agence'] ?></td>
                                <td><?= htmlspecialchars($agence['nom']) ?></td>
                                <td>
                                    <a href="/admin/agence/edit/<?= $agence['id_agence'] ?>" class="btn btn-warning btn-sm">
                                        Modifier
                                    </a>
                                    <form method="POST" action="/admin/agence/delete/<?= $agence['id_agence'] ?>" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette agence ?')">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>