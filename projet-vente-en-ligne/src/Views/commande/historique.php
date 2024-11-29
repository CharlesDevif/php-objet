<div class="container mt-4">
    <h1>Historique des commandes</h1>

    <?php if (!empty($commandes)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandes as $commande): ?>
                    <tr>
                        <td><?= htmlspecialchars($commande['id']); ?></td>
                        <td><?= htmlspecialchars($commande['date_creation']); ?></td>
                        <td><?= number_format($commande['total'], 2, ',', ' ') . ' €'; ?></td>
                        <td><?= htmlspecialchars($commande['etat']); ?></td>
                        <td>
                            <a href="/projet-vente-en-ligne/commande/detail/<?= $commande['id']; ?>" class="btn btn-primary btn-sm">
                                Voir détails
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Vous n'avez pas encore passé de commande.</p>
    <?php endif; ?>
</div>
