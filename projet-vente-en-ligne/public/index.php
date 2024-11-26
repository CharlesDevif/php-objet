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




