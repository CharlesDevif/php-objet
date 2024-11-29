<div class="container mt-4">
    <h1>Confirmation de commande</h1>

    <h2>Articles</h2>
    <ul>
        <?php foreach ($articles as $article): ?>
            <li>
                <?= htmlspecialchars($article['produit']->getNom()) ?> - 
                Quantité : <?= $article['quantite'] ?> - 
                Prix : <?= number_format($article['produit']->getPrix(), 2, ',', ' ') ?> €
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Total : <?= number_format($total, 2, ',', ' ') ?> €</h3>

    <form method="POST" action="/projet-vente-en-ligne/panier/validerCommande">
        <button type="submit" class="btn btn-success">Valider la commande</button>
    </form>

    <a href="/projet-vente-en-ligne/panier" class="btn btn-secondary">Retour au panier</a>
</div>
