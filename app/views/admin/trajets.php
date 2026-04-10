<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Liste des trajets</h1>
    <a href="/admin" class="btn btn-secondary">← Retour au tableau de bord</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($trajets)): ?>
            <p class="text-muted">Aucun trajet enregistré.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Départ</th>
                            <th>Arrivée</th>
                            <th>Date départ</th>
                            <th>Places</th>
                            <th>Auteur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trajets as $trajet): ?>
                            <tr>
                                <td><?= $trajet['id_trajet'] ?></td>
                                <td><?= htmlspecialchars($trajet['agence_depart_nom']) ?></td>
                                <td><?= htmlspecialchars($trajet['agence_arrivee_nom']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($trajet['gdh_depart'])) ?></td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= $trajet['nb_places_dispo'] ?>/<?= $trajet['nb_places_total'] ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($trajet['employe_prenom'] . ' ' . $trajet['employe_nom']) ?></td>
                                <td>
                                    <form method="POST" action="/admin/trajet/delete/<?= $trajet['id_trajet'] ?>" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?')">
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