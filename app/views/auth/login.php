<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="login-container">
    <div class="login-card card">
        <div class="card-body p-5">
            <h2 class="text-center mb-4">Connexion</h2>
            
            <?php if (isset($_SESSION['errors']['login'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['errors']['login']) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/login">
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        class="form-control <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : '' ?>" 
                        id="email" 
                        name="email" 
                        value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                        required
                        autofocus
                    >
                    <?php if (isset($_SESSION['errors']['email'])): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($_SESSION['errors']['email']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Mot de passe -->
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input 
                        type="password" 
                        class="form-control <?= isset($_SESSION['errors']['password']) ? 'is-invalid' : '' ?>" 
                        id="password" 
                        name="password" 
                        required
                    >
                    <?php if (isset($_SESSION['errors']['password'])): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($_SESSION['errors']['password']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>

            <hr class="my-4">
            
            <div class="text-center text-muted small">
                <p><strong>Comptes de test :</strong></p>
                <p>Admin : admin@klaxon.fr / Admin123!</p>
                <p>User : alexandre.martin@email.fr / Password123!</p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>