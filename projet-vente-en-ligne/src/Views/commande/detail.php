<div class="container mt-4">
    <h1 class="text-center text-uppercase mb-4">Détails de la commande #<?= htmlspecialchars($commande['id']); ?></h1>

    <!-- Informations sur la commande -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <p><strong>Date :</strong> <?= htmlspecialchars($commande['date_creation']); ?></p>
            <p><strong>Total :</strong> <span class="badge bg-success"><?= number_format($commande['total'], 2, ',', ' ') . ' €'; ?></span></p>
            <p><strong>État :</strong> <span class="badge <?= $commande['etat'] === 'livrée' ? 'bg-success' : ($commande['etat'] === 'en_cours' ? 'bg-warning' : 'bg-info'); ?>">
                <?= htmlspecialchars(ucfirst($commande['etat'])); ?></span>
            </p>
        </div>
    </div>

    <!-- Liste des articles -->
    <h3 class="mb-3">Articles commandés</h3>
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>Produit</th>
                <th class="text-center">Quantité</th>
                <th class="text-end">Prix unitaire</th>
                <th class="text-end">Sous-total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commande['articles'] as $article): ?>
                <tr>
                    <td><?= htmlspecialchars($article['nom']); ?></td>
                    <td class="text-center"><?= htmlspecialchars($article['quantite']); ?></td>
                    <td class="text-end"><?= number_format($article['prix_unitaire'], 2, ',', ' ') . ' €'; ?></td>
                    <td class="text-end"><?= number_format($article['quantite'] * $article['prix_unitaire'], 2, ',', ' ') . ' €'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
