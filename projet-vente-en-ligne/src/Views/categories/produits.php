<section class="container mt-3">
    <h1>Produits dans la catégorie : <?= htmlspecialchars($categorie->getNom()); ?></h1>

    <?php if (isset($utilisateur) && $utilisateur->verifierRole(['ROLE_ADMIN', 'ROLE_VENDEUR'])): ?>
        <a href="/projet-vente-en-ligne/categorie/ajouterProduit/<?= $categorie->getId(); ?>" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Ajouter un produit
        </a>
    <?php endif; ?>

    <?php if (empty($produits)): ?>
        <div class="alert alert-info">Aucun produit dans cette catégorie.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($produits as $produit): ?>

                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($produit->getNom()); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($produit->getDescription()); ?></p>
                            <p class="card-text"><strong>Prix :</strong> <?= number_format($produit->getPrix(), 2); ?> €</p>
                            <a href="/projet-vente-en-ligne/panier/ajouter/<?= $produit->getId(); ?>" class="btn btn-primary">
                                <i class="fas fa-cart-plus"></i> Ajouter au panier
                            </a>
                            <?php if (isset($utilisateur) && $utilisateur->verifierRole(['ROLE_ADMIN', 'ROLE_VENDEUR'])): ?>
                                <a href="/projet-vente-en-ligne/categorie/supprimerProduit/<?= $categorie->getId(); ?>/<?= $produit->getId(); ?>"
                                    class="btn btn-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit de la catégorie ?');">
                                    <i class="fas fa-trash"></i> Supprimer
                                </a>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="/projet-vente-en-ligne/categorie" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour aux catégories
    </a>

</section>