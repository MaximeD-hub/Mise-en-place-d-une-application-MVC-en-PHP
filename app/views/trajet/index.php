<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h1 class="mb-4">Trajets disponibles</h1>

<?php if (empty($trajets)): ?>
    <div class="alert alert-info">
        <p class="mb-0">Aucun trajet disponible pour le moment.</p>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($trajets as $trajet): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card trajet-card">
                    <div class="card-header">
                        <?= htmlspecialchars($trajet['agence_depart_nom']) ?> 
                        → 
                        <?= htmlspecialchars($trajet['agence_arrivee_nom']) ?>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Départ :</strong> 
                            <?= date('d/m/Y à H:i', strtotime($trajet['gdh_depart'])) ?>
                        </p>
                        <p class="mb-2">
                            <strong>Arrivée :</strong> 
                            <?= date('d/m/Y à H:i', strtotime($trajet['gdh_arrivee'])) ?>
                        </p>
                        <p class="mb-3">
                            <span class="badge badge-places bg-success">
                                <?= $trajet['nb_places_dispo'] ?> place(s) disponible(s)
                            </span>
                        </p>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <!-- Boutons pour utilisateur connecté -->
                            <div class="d-flex gap-2 flex-wrap">
                                <button 
                                    class="btn btn-primary btn-sm"
                                    onclick="showDetails(<?= $trajet['id_trajet'] ?>)"
                                >
                                    Voir détails
                                </button>

                                <?php if ($trajet['id_employe'] == $_SESSION['user_id']): ?>
                                    <a href="/trajet/edit/<?= $trajet['id_trajet'] ?>" class="btn btn-warning btn-sm">
                                        Modifier
                                    </a>
                                    <form method="POST" action="/trajet/delete/<?= $trajet['id_trajet'] ?>" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Supprimer
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Modal pour les détails -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails du trajet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Contenu chargé dynamiquement -->
            </div>
        </div>
    </div>
</div>

<script>
function showDetails(trajetId) {
    fetch('/trajet/details/' + trajetId)
        .then(response => response.json())
        .then(data => {
            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                <p><strong>Contact :</strong> ${data.employe_prenom} ${data.employe_nom}</p>
                <p><strong>Email :</strong> <a href="mailto:${data.employe_email}">${data.employe_email}</a></p>
                <p><strong>Téléphone :</strong> <a href="tel:${data.employe_telephone}">${data.employe_telephone}</a></p>
                <p><strong>Places totales :</strong> ${data.nb_places_total}</p>
                <p><strong>Places disponibles :</strong> ${data.nb_places_dispo}</p>
            `;
            const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
            modal.show();
        })
        .catch(error => {
            alert('Erreur lors du chargement des détails');
        });
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>