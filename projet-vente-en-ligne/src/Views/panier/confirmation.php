<div class="container mt-5">
    <h1 class="text-center mb-4">Confirmation de commande</h1>

    <!-- Section des articles -->
    <div class="p-4 bg-light rounded shadow-sm">
        <h2 class="mb-3">Détails des articles</h2>
        <ul class="list-group">
            <?php foreach ($articles as $article): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <strong><?= htmlspecialchars($article['produit']->getNom()) ?></strong>
                        <br>
                        Quantité : <?= $article['quantite'] ?>
                    </span>
                    <span class="badge bg-success rounded-pill">
                        <?= number_format($article['produit']->getPrix(), 2, ',', ' ') ?> €
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Section total -->
    <div class="mt-4 p-3 bg-white rounded shadow-sm d-flex justify-content-between align-items-center">
        <h3>Total : <span class="text-success"><?= number_format($total, 2, ',', ' ') ?> €</span></h3>
    </div>

    <!-- Boutons d'action -->
    <div class="mt-4 d-flex justify-content-between">
        <a href="/projet-vente-en-ligne/panier" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Retour au panier
        </a>
        <form method="POST" action="/projet-vente-en-ligne/panier/validerCommande">
            <button type="submit" class="btn btn-outline-success">
                <i class="fas fa-check"></i> Valider la commande
            </button>
        </form>
    </div>
</div>

<style>
    body {
        background-color: #f9f9f9;
        font-family: 'Arial', sans-serif;
    }

    h1, h2 {
        color: #333;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    .list-group-item {
        border: none;
        border-bottom: 1px solid #ddd;
        padding: 15px 10px;
        font-size: 1rem;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .badge {
        font-size: 1rem;
        padding: 10px 15px;
    }

    .btn-outline-success, .btn-outline-secondary {
        padding: 10px 20px;
        font-size: 1rem;
        transition: transform 0.3s ease-in-out;
    }

    .btn-outline-success:hover, .btn-outline-secondary:hover {
        transform: scale(1.05);
    }

    .shadow-sm {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
