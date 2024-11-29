<section class="container mt-4">
    <h1>Connexion</h1>
    <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur); ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control" required>
        </div>
        <button type="submit" name="connexion" class="btn btn-primary">Se connecter</button>
    </form>
    <p class="mt-3">
        Pas encore inscrit ? <a href="/projet-vente-en-ligne/utilisateur/inscription">Créer un compte</a>
    </p>
</section>