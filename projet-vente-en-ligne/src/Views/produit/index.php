
    <div class="container mt-4">
        <h1 class="mb-4">Liste des Produits</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit): ?>
                <tr>
                    <td><?= $produit->getId(); ?></td>
                    <td><?= $produit->getNom(); ?></td>
                    <td><?= $produit->getDescription(); ?></td>
                    <td><?= number_format($produit->getPrix(), 2, ',', ' '); ?> €</td>
                    <td><?= $produit->getStock(); ?></td>
                    <td>
                        <a href="/projet-vente-en-ligne/produit/supprimer/<?= $produit->getId(); ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

