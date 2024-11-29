<div class="container mt-4">
    <h1 class="mb-4 text-center">Historique des commandes</h1>

    <?php if (!empty($commandes)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle shadow-sm rounded">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Total</th>
                        <th scope="col">État</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $commande): ?>
                        <tr>
                            <th scope="row"><?= htmlspecialchars($commande['id']); ?></th>
                            <td><?= htmlspecialchars($commande['date_creation']); ?></td>
                            <td><?= number_format($commande['total'], 2, ',', ' ') . ' €'; ?></td>
                            <td>
                                <span class="badge 
                                    <?= $commande['etat'] === 'livree' ? 'bg-success' : 
                                        ($commande['etat'] === 'en_preparation' ? 'bg-warning text-dark' : 'bg-secondary'); ?>">
                                    <?= htmlspecialchars($commande['etat']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="/projet-vente-en-ligne/commande/detail/<?= $commande['id']; ?>" class="btn btn-outline-primary btn-sm">
                                    Voir détails
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            <p class="mb-0">Vous n'avez pas encore passé de commande.</p>
        </div>
    <?php endif; ?>
</div>

<style>
   

    /* Table */
    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead th {
        text-transform: uppercase;
        font-size: 0.9rem;
        font-weight: bold;
        background-color: #343a40;
        color: #fff;
        border: none;
    }

    .table tbody tr {
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Buttons */
    .btn {
        transition: all 0.3s ease;
    }

    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }

    /* Badge */
    .badge {
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 12px;
    }

    /* Alert */
    .alert {
        margin-top: 20px;
        font-size: 1rem;
        padding: 15px;
    }
</style>
