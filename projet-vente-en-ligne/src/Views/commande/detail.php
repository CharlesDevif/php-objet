<div class="container mt-4">
    <h1>Détails de la commande #<?= htmlspecialchars($commande['id']); ?></h1>

    <p><strong>Date :</strong> <?= htmlspecialchars($commande['date_creation']); ?></p>
    <p><strong>Total :</strong> <?= number_format($commande['total'], 2, ',', ' ') . ' €'; ?></p>
    <p><strong>État :</strong> <?= htmlspecialchars($commande['etat']); ?></p>

    <h3>Articles :</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commande['articles'] as $article): ?>
                <tr>
                    <td><?= htmlspecialchars($article['nom']); ?></td>
                    <td><?= htmlspecialchars($article['quantite']); ?></td>
                    <td><?= number_format($article['prix_unitaire'], 2, ',', ' ') . ' €'; ?></td>
                    <td><?= number_format($article['quantite'] * $article['prix_unitaire'], 2, ',', ' ') . ' €'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
