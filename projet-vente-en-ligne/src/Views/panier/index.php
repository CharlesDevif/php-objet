<div class="container mt-4">
    <h1>Mon Panier</h1>

    <?php if (!empty($articles)): ?>
        <table class="table">
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
                            <form method="POST" action="/projet-vente-en-ligne/panier/retirer">
                                <input type="hidden" name="id_produit" value="<?= $article['produit']->getId(); ?>">
                                <input type="hidden" name="quantite" value="1">
                                <button class="btn btn-danger btn-sm" type="submit">Retirer 1</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="mt-3">
            <h3>Total : <?= number_format($total, 2, ',', ' ') . ' €'; ?></h3>
            <a href="/projet-vente-en-ligne/commande" class="btn btn-success">Passer la commande</a>
        </div>
    <?php else: ?>
        <p>Votre panier est vide.</p>
    <?php endif; ?>
</div>
