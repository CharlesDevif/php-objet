<div class="container mt-4">
    <h1 class="text-center mb-4">Mon Panier</h1>

    <!-- Messages de succès ou d'erreur -->
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($_SESSION['success_message']); ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['erreur_panier'])): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($_SESSION['erreur_panier']); ?>
            <?php unset($_SESSION['erreur_panier']); ?>
        </div>
    <?php endif; ?>

    <!-- Affichage des articles -->
    <?php if (!empty($articles)): ?>
        <table class="table table-hover table-responsive-md">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                    <tr class="text-center align-middle">
                        <td><?= htmlspecialchars($article['produit']->getNom()); ?></td>
                        <td><?= number_format($article['produit']->getPrix(), 2, ',', ' ') . ' €'; ?></td>
                        <td><?= $article['quantite']; ?></td>
                        <td><?= number_format($article['produit']->getPrix() * $article['quantite'], 2, ',', ' ') . ' €'; ?></td>
                        <td>
                            <!-- Formulaire pour retirer une unité -->
                            <form method="POST" action="/projet-vente-en-ligne/panier/retirer" class="d-inline">
                                <input type="hidden" name="id_produit" value="<?= $article['produit']->getId(); ?>">
                                <input type="hidden" name="quantite" value="1">
                                <button class="btn btn-outline-danger btn-sm" type="submit">- 1</button>
                            </form>

                            <!-- Formulaire pour vider complètement cet article -->
                            <form method="POST" action="/projet-vente-en-ligne/panier/retirer" class="d-inline">
                                <input type="hidden" name="id_produit" value="<?= $article['produit']->getId(); ?>">
                                <input type="hidden" name="quantite" value="<?= $article['quantite']; ?>">
                                <button class="btn btn-outline-warning btn-sm" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Total et actions -->
        <div class="mt-4 p-4 rounded shadow-sm bg-light d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Total : <span class="text-success"><?= number_format($total, 2, ',', ' ') . ' €'; ?></span></h3>
            <div class="d-flex gap-3">
                <a href="/projet-vente-en-ligne/panier/vider" class="btn btn-outline-danger">Vider le panier</a>
                <a href="/projet-vente-en-ligne/panier/confirmationCommande" class="btn btn-outline-success">Passer la commande</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center mt-4">Votre panier est vide.</div>
    <?php endif; ?>
</div>


