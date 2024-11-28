<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Inscription</h1>
    <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur); ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type d'utilisateur</label>
            <select name="type" id="type" class="form-select" required>
                <option value="client">Client</option>
                <option value="vendeur">Vendeur</option>
            </select>
        </div>
        <div id="client-fields" class="d-none">
            <div class="mb-3">
                <label for="adresse_livraison" class="form-label">Adresse de livraison</label>
                <input type="text" name="adresse_livraison" id="adresse_livraison" class="form-control">
            </div>
        </div>
        <div id="vendeur-fields" class="d-none">
            <div class="mb-3">
                <label for="boutique" class="form-label">Nom de la boutique</label>
                <input type="text" name="boutique" id="boutique" class="form-control">
            </div>
            <div class="mb-3">
                <label for="commission" class="form-label">Commission (%)</label>
                <input type="number" step="0.01" name="commission" id="commission" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
    <p class="mt-3">
        Déjà inscrit ? <a href="/projet-vente-en-ligne/utilisateur/connexion">Se connecter</a>
    </p>
</div>
<script>
    document.getElementById('type').addEventListener('change', function () {
        const clientFields = document.getElementById('client-fields');
        const vendeurFields = document.getElementById('vendeur-fields');

        if (this.value === 'client') {
            clientFields.classList.remove('d-none');
            vendeurFields.classList.add('d-none');
        } else {
            clientFields.classList.add('d-none');
            vendeurFields.classList.remove('d-none');
        }
    });
</script>

</body>
</html>
