<div class="container mt-4">
    <h1 class="text-center">Nos Produits</h1>

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

    <!-- Barre de recherche -->
    <div class="mb-4">
        <input type="text" id="search" class="form-control" placeholder="Rechercher un produit...">
    </div>

    <!-- Parcourir les catégories et afficher les produits -->
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $categorieNom => $produits): ?>
            <h2 class="mt-4"><?= htmlspecialchars($categorieNom); ?></h2>
            <div class="row grid-container">
                <?php foreach ($produits as $produit): ?>
                    <div class="col-md-4 mb-3 card mx-auto">
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
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">Aucun produit disponible pour le moment.</div>
    <?php endif; ?>

    <!-- Section pour les produits sans catégorie -->
    <?php if (!empty($produitsSansCategorie)): ?>
        <h2 class="mt-4">Produits sans catégorie</h2>
        <div class="row grid-container">
            <?php foreach ($produitsSansCategorie as $produit): ?>
                <div class="col-md-4 mb-3 card mx-auto">
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
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Global styles */
    body {
        max-height: 100vh;
        overflow-y: auto;
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
        color: #333;
        line-height: 1.6;
    }

    .container {
        margin-bottom: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 40px;
        color: #2c3e50;
        font-size: 2.5rem;
        font-weight: bold;
        position: relative;
    }

    h1::after {
        content: '';
        display: block;
        width: 100px;
        height: 4px;
        background: #4CAF50;
        margin: 10px auto 0;
        border-radius: 2px;
    }

    h2 {
        color: #4CAF50;
        border-bottom: 2px solid #4CAF50;
        display: inline-block;
        padding-bottom: 5px;
        font-size: 1.5rem;
        margin-top: 40px;
        margin-bottom: 20px;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    /* Card styles */
    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        background-color: #fff;
        width: fit-content;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .card h5 {
        color: #34495e;
        font-size: 1.25rem;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .card p {
        margin: 0 0 10px;
    }

    .card .badge {
        padding: 5px 10px;
        font-size: 0.9rem;
        border-radius: 20px;
    }

    .badge.bg-success {
        background-color: #27ae60;
        color: #fff;
    }

    .badge.bg-danger {
        background-color: #e74c3c;
        color: #fff;
    }

    .btn-primary {
        transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out;
    }



    /* Search bar */
    #search {
        border-radius: 30px;
        padding: 10px 20px;
        border: 1px solid #ddd;
        transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    #search:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        outline: none;
    }

    /* Spacing for large screens */
    @media (min-width: 768px) {
        .card-body {
            padding: 20px;
        }
    }
</style>


<script>
    // Barre de recherche
    document.getElementById('search').addEventListener('input', function() {
        const searchText = this.value.toLowerCase();
        document.querySelectorAll('.card').forEach(card => {
            const productName = card.querySelector('.card-title').textContent.toLowerCase();
            card.style.display = productName.includes(searchText) ? '' : 'none';
        });
    });
</script>