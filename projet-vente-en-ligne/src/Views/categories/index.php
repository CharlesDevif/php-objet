<h1>Liste des Catégories</h1>

<?php if (isset($_SESSION['utilisateur'])): ?>
    <?php $utilisateur = unserialize($_SESSION['utilisateur']); ?>
    <?php if (in_array('ROLE_VENDEUR', $utilisateur->getRoles()) || in_array('ROLE_ADMIN', $utilisateur->getRoles())): ?>
        <a href="/projet-vente-en-ligne/categorie/add" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Ajouter une catégorie
        </a>
    <?php endif; ?>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $categorie): ?>
            <tr>
                <td><?= htmlspecialchars($categorie->getId()); ?></td>
                <td>
                    <a href="/projet-vente-en-ligne/categorie/produits/<?= $categorie->getId(); ?>">
                        <?= htmlspecialchars($categorie->getNom()); ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($categorie->getDescription()); ?></td>
                <td>
                    <?php if (isset($utilisateur) && (in_array('ROLE_VENDEUR', $utilisateur->getRoles()) || in_array('ROLE_ADMIN', $utilisateur->getRoles()))): ?>
                        <a href="/projet-vente-en-ligne/categorie/modifier/<?= $categorie->getId(); ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="/projet-vente-en-ligne/categorie/supprimer/<?= $categorie->getId(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')">
                            <i class="fas fa-trash"></i> Supprimer
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
