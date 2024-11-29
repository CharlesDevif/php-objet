<section class="container mt-3">
    <h1>Modifier la Catégorie</h1>
    <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($categorie->getNom()); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" required><?= htmlspecialchars($categorie->getDescription()); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
    </form>
</section>