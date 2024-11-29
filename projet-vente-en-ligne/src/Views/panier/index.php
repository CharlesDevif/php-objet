<div class="container mt-4">
    <h1>Mon Panier</h1>

    <!-- Messages de succès ou d'erreur -->
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success_message']); ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['erreur_panier'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['erreur_panier']); ?>
            <?php unset($_SESSION['erreur_panier']); ?>
        </div>
    <?php endif; ?>

    <!-- Affichage des articles -->
    <?php if (!empty($articles)): ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= htmlspecialchars($article['produit']->getNom()); ?></td>
                        <td><?= number_format($article['produit']->getPrix(), 2, ',', ' ') . ' €'; ?></td>
                        <td><?= $article['quantite']; ?></td>
                        <td><?= number_format($article['produit']->getPrix() * $article['quantite'], 2, ',', ' ') . ' €'; ?></td>
                        <td>
                            <!-- Formulaire pour retirer une unité -->
                            <form method="POST" action="/projet-vente-en-ligne/panier/retirer" style="display: inline;">
                                <input type="hidden" name="id_produit" value="<?= $article['produit']->getId(); ?>">
                                <input type="hidden" name="quantite" value="1">
                                <button class="btn btn-danger btn-sm" type="submit">- 1</button>
                            </form>

                            <!-- Formulaire pour vider complètement cet article -->
                            <form method="POST" action="/projet-vente-en-ligne/panier/retirer" style="display: inline;">
                                <input type="hidden" name="id_produit" value="<?= $article['produit']->getId(); ?>">
                                <input type="hidden" name="quantite" value="<?= $article['quantite']; ?>">
                                <button class="btn btn-warning btn-sm" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Total et actions -->
        <div class="mt-3 d-flex justify-content-between align-items-center">
    <h3>Total : <?= number_format($total, 2, ',', ' ') . ' €'; ?></h3>
    <div>
        <a href="/projet-vente-en-ligne/panier/vider" class="btn btn-danger">Vider le panier</a>
        <a href="/projet-vente-en-ligne/panier/confirmationCommande" class="btn btn-success">Passer la commande</a>
    </div>
</div>

    <?php else: ?>
        <div class="alert alert-info">Votre panier est vide.</div>
    <?php endif; ?>
</div>
