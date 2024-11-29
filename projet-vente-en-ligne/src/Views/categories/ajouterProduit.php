<section class="container mt-3">
    <h1>Ajouter un produit à la catégorie : <?= htmlspecialchars($categorie->getNom()); ?></h1>

    <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="produit_id" class="form-label">Produit</label>
            <select name="produit_id" id="produit_id" class="form-select" required>
                <option value="">-- Sélectionnez un produit --</option>
                <?php foreach ($produitsDisponibles as $produit): ?>
                    <option value="<?= $produit->getId(); ?>"><?= htmlspecialchars($produit->getNom()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter</button>
    </form>

    <a href="/projet-vente-en-ligne/categorie/produits/<?= $categorie->getId(); ?>" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Retour à la catégorie
    </a>
</section>