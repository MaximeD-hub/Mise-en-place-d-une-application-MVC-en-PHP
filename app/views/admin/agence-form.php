<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">
                    <?= $agence ? 'Modifier une agence' : 'Créer une agence' ?>
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= $agence ? '/admin/agence/update/' . $agence['id_agence'] : '/admin/agence/store' ?>">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de l'agence *</label>
                        <input 
                            type="text" 
                            class="form-control <?= isset($_SESSION['errors']['nom']) ? 'is-invalid' : '' ?>" 
                            id="nom" 
                            name="nom" 
                            value="<?= htmlspecialchars($agence['nom'] ?? $_SESSION['old']['nom'] ?? '') ?>"
                            required
                            autofocus
                        >
                        <?php if (isset($_SESSION['errors']['nom'])): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($_SESSION['errors']['nom']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/admin/agences" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">
                            <?= $agence ? 'Modifier' : 'Créer' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>