<div class="container mt-4">
    <h1>Nos Produits</h1>
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($produits as $produit): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($produit->getNom()); ?></h5>
                        <p class="card-text"><?= htmlspecialchars($produit->getDescription()); ?></p>
                        <p class="card-text"><strong><?= number_format($produit->getPrix(), 2, ',', ' ') . ' €'; ?></strong></p>
                        <form method="POST" action="/projet-vente-en-ligne/home/ajouterAuPanier">
                            <input type="hidden" name="id_produit" value="<?= $produit->getId(); ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-cart-plus"></i> Ajouter au panier
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
