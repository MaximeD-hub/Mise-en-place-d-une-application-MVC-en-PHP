<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Proposer un trajet</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/trajet/store">
                    <!-- Informations utilisateur (lecture seule) -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['user_nom']) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['user_prenom']) ?>" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($_SESSION['user_email']) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Téléphone</label>
                            <input type="text" class="form-control" value="(depuis votre profil)" readonly>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Agences -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_agence_depart" class="form-label">Agence de départ *</label>
                            <select 
                                class="form-select <?= isset($_SESSION['errors']['id_agence_depart']) ? 'is-invalid' : '' ?>" 
                                id="id_agence_depart" 
                                name="id_agence_depart" 
                                required
                            >
                                <option value="">-- Sélectionner --</option>
                                <?php foreach ($agences as $agence): ?>
                                    <option 
                                        value="<?= $agence['id_agence'] ?>"
                                        <?= (isset($_SESSION['old']['id_agence_depart']) && $_SESSION['old']['id_agence_depart'] == $agence['id_agence']) ? 'selected' : '' ?>
                                    >
                                        <?= htmlspecialchars($agence['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($_SESSION['errors']['id_agence_depart'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= htmlspecialchars($_SESSION['errors']['id_agence_depart']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label for="id_agence_arrivee" class="form-label">Agence d'arrivée *</label>
                            <select 
                                class="form-select <?= isset($_SESSION['errors']['id_agence_arrivee']) ? 'is-invalid' : '' ?>" 
                                id="id_agence_arrivee" 
                                name="id_agence_arrivee" 
                                required
                            >
                                <option value="">-- Sélectionner --</option>
                                <?php foreach ($agences as $agence): ?>
                                    <option 
                                        value="<?= $agence['id_agence'] ?>"
                                        <?= (isset($_SESSION['old']['id_agence_arrivee']) && $_SESSION['old']['id_agence_arrivee'] == $agence['id_agence']) ? 'selected' : '' ?>
                                    >
                                        <?= htmlspecialchars($agence['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($_SESSION['errors']['id_agence_arrivee'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= htmlspecialchars($_SESSION['errors']['id_agence_arrivee']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="gdh_depart" class="form-label">Date et heure de départ *</label>
                            <input 
                                type="datetime-local" 
                                class="form-control <?= isset($_SESSION['errors']['gdh_depart']) ? 'is-invalid' : '' ?>" 
                                id="gdh_depart" 
                                name="gdh_depart" 
                                value="<?= htmlspecialchars($_SESSION['old']['gdh_depart'] ?? '') ?>"
                                required
                            >
                            <?php if (isset($_SESSION['errors']['gdh_depart'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($_SESSION['errors']['gdh_depart']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label for="gdh_arrivee" class="form-label">Date et heure d'arrivée *</label>
                            <input 
                                type="datetime-local" 
                                class="form-control <?= isset($_SESSION['errors']['gdh_arrivee']) ? 'is-invalid' : '' ?>" 
                                id="gdh_arrivee" 
                                name="gdh_arrivee" 
                                value="<?= htmlspecialchars($_SESSION['old']['gdh_arrivee'] ?? '') ?>"
                                required
                            >
                            <?php if (isset($_SESSION['errors']['gdh_arrivee'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($_SESSION['errors']['gdh_arrivee']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Nombre de places -->
                    <div class="mb-3">
                        <label for="nb_places_total" class="form-label">Nombre de places disponibles *</label>
                        <input 
                            type="number" 
                            class="form-control <?= isset($_SESSION['errors']['nb_places_total']) ? 'is-invalid' : '' ?>" 
                            id="nb_places_total" 
                            name="nb_places_total" 
                            min="1" 
                            max="8" 
                            value="<?= htmlspecialchars($_SESSION['old']['nb_places_total'] ?? '4') ?>"
                            required
                        >
                        <?php if (isset($_SESSION['errors']['nb_places_total'])): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($_SESSION['errors']['nb_places_total']) ?>
                            </div>
                        <?php endif; ?>
                        <small class="text-muted">Entre 1 et 8 places</small>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-between">
                        <a href="/" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Créer le trajet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>