<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Factory\ProduitFactory;

echo "=== Test de la ProduitFactory ===\n";

try {
    // Création d'un produit physique via la factory
    $dataPhysique = [
        'nom' => 'Imprimante 3D',
        'description' => 'Une imprimante 3D de haute précision.',
        'prix' => 2500.00,
        'stock' => 3,
        'poids' => 15.0,
        'longueur' => 50.0,
        'largeur' => 40.0,
        'hauteur' => 45.0,
    ];
    $imprimante3D = ProduitFactory::creerProduit('physique', $dataPhysique);
    $imprimante3D->afficherDetails();
    echo "Prix TTC : " . $imprimante3D->calculerPrixTTC() . "€\n";
    echo "Frais de livraison : " . $imprimante3D->calculerFraisLivraison() . "€\n\n";

    // Création d'un produit numérique via la factory
    $dataNumerique = [
        'nom' => 'Logiciel de modélisation 3D',
        'description' => 'Un logiciel pour créer des modèles 3D.',
        'prix' => 499.99,
        'stock' => 100,
        'lienTelechargement' => 'https://exemple.com/telechargement/logiciel-3d',
        'tailleFichier' => 200.0,
        'formatFichier' => 'exe',
    ];
    $logiciel3D = ProduitFactory::creerProduit('numerique', $dataNumerique);
    $logiciel3D->afficherDetails();
    echo "Prix TTC : " . $logiciel3D->calculerPrixTTC() . "€\n";
    echo "Frais de livraison : " . $logiciel3D->calculerFraisLivraison() . "€\n\n";

    // Création d'un produit périssable via la factory
    $dataPerissable = [
        'nom' => 'Saumon fumé',
        'description' => 'Un saumon fumé de Norvège.',
        'prix' => 30.00,
        'stock' => 20,
        'dateExpiration' => '2024-12-31',
        'temperatureStockage' => 2.0,
    ];
    $saumonFume = ProduitFactory::creerProduit('perissable', $dataPerissable);
    $saumonFume->afficherDetails();
    echo "Prix TTC : " . $saumonFume->calculerPrixTTC() . "€\n";
    echo "Frais de livraison : " . $saumonFume->calculerFraisLivraison() . "€\n\n";

} catch (\Exception $e) {
    echo "Erreur lors de la création du produit : " . $e->getMessage() . "\n";
}


use App\Config\ConfigurationManager;

echo "=== Test du ConfigurationManager ===\n";

$configManager = ConfigurationManager::getInstance();

echo "TVA actuelle : " . $configManager->get('tva') . "%\n";
echo "Devise actuelle : " . $configManager->get('devise') . "\n";

echo "Modification de la TVA à 10%\n";
$configManager->set('tva', 10);

echo "Nouvelle TVA : " . $configManager->get('tva') . "%\n";

// Recalcul du prix TTC avec la nouvelle TVA
echo "Recalcul du prix TTC du logiciel 3D avec la nouvelle TVA :\n";
echo "Prix TTC : " . $logiciel3D->calculerPrixTTC() . "€\n";


use App\Database\DatabaseConnection;

try {
    $dbConnection = DatabaseConnection::getInstance();
    echo "Connexion à la base de données établie avec succès.\n";
} catch (Exception $e) {
    echo "Erreur de connexion : " . $e->getMessage() . "\n";
}



// Le vendeur ajoute un produit (fonctionnalité à implémenter)
$vendeur->ajouterProduit($produitPhysique);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDSI PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container p-4">
        <div class="row gap-5">
            <h2>Ajout de produits</h2>

            <!-- ProduitNumerique -->
            <div class="col card p-3">
                <h3>Ajout Produit Numérique</h3>
                <form>
                    <div class="mb-3">
                        <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                        <input type="text" class="form-control" id="inputNomProduit">
                    </div>
                    <div class="mb-3 form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription"></textarea>
                        <label for="textAreaDescription">Description</label>
                    </div>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)">
                        <span class="input-group-text">€</span>
                    </div>
                    <div class="mb-2">
                        <label for="numberStock" class="form-label">Stock</label>
                        <input type="number" id="numberStock" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Sélectionner le fichier à importer.</label>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>

            <!-- ProduitPerissable -->
            <div class="col card p-3">
                <h3>Ajout Produit Périssable</h3>
                <form>
                    <div class="mb-3">
                        <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                        <input type="text" class="form-control" id="inputNomProduit">
                    </div>
                    <div class="mb-3 form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription"></textarea>
                        <label for="textAreaDescription">Description</label>
                    </div>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)">
                        <span class="input-group-text">€</span>
                    </div>
                    <div class="mb-3">
                        <label for="numberStock" class="form-label">Stock</label>
                        <input type="number" id="numberStock" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>

            <!-- ProduitPhysique -->
            <div class="col card p-3">
                <h3>Ajout Produit Physique</h3>
                <form>
                    <div class="mb-3">
                        <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                        <input type="text" class="form-control" id="inputNomProduit">
                    </div>
                    <div class="mb-3 form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription"></textarea>
                        <label for="textAreaDescription">Description</label>
                    </div>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)">
                        <span class="input-group-text">€</span>
                    </div>
                    <div class="mb-3">
                        <label for="numberStock" class="form-label">Stock</label>
                        <input type="number" id="numberStock" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>