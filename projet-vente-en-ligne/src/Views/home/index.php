<div class="container mt-4">
    <h1>Nos Produits</h1>

    <!-- Messages de succès ou d'erreur -->
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success_message']); ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error_message']); ?>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if (!empty($produits)): ?>
            <?php foreach ($produits as $produit): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($produit->getNom()); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($produit->getDescription()); ?></p>
                            <p class="card-text"><strong>Prix :</strong> <?= number_format($produit->getPrix(), 2, ',', ' ') . ' €'; ?></p>

                            <!-- Quantité en stock -->
                            <?php if ($produit->getStock() > 0): ?>
                                <span class="badge bg-success">En stock : <?= $produit->getStock(); ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger">Rupture de stock</span>
                            <?php endif; ?>

                            <!-- Formulaire pour ajouter au panier -->
                            <form method="POST" action="/projet-vente-en-ligne/home/ajouterAuPanier" class="mt-2">
                                <input type="hidden" name="id_produit" value="<?= $produit->getId(); ?>">
                                <button type="submit" class="btn btn-primary" <?= $produit->getStock() <= 0 ? 'disabled' : ''; ?>>
                                    <i class="fas fa-cart-plus"></i> Ajouter au panier
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">Aucun produit disponible pour le moment.</div>
        <?php endif; ?>
    </div>
</div>
