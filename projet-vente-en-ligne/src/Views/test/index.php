<?php

// Importation des classes nécessaires
use App\Config\ConfigurationManager;
use App\Database\DatabaseConnection;
use App\Factory\ProduitFactory;
use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\CategorieRepository;
use App\Entity\Produit\ProduitPhysique;
use App\Entity\Produit\ProduitNumerique;
use App\Entity\Produit\ProduitPerissable;
use App\Entity\Utilisateur\Client;
use App\Entity\Utilisateur\Admin;
use App\Entity\Utilisateur\Vendeur;
use App\Entity\Categorie;
use App\Entity\Panier;

// === Jour 1 - Tests pour les classes Produit et Utilisateur ===

printf("=== Jour 1 - Tests pour les classes Produit et Utilisateur ===\n\n");

// Tests pour la classe Produit
echo "--- Tests pour la classe Produit ---\n";

// Utilisation de ProduitPhysique pour les tests du Jour 1
$produit = new ProduitPhysique(
    "Ordinateur portable",
    "Un ordinateur performant",
    1200.00,
    5,
    2.5,  // poids en kg
    35.0, // longueur en cm
    24.0, // largeur en cm
    2.0   // hauteur en cm
);

echo "Produit créé : " . $produit->getNom() . "\n";
echo "Description : " . $produit->getDescription() . "\n";
echo "Prix HT : " . $produit->getPrix() . "€\n";
echo "Stock : " . $produit->getStock() . "\n";

// Modification des propriétés via les setters
$produit->setPrix(1100.00);
$produit->setStock(10);

echo "Nouveau prix HT : " . $produit->getPrix() . "€\n";
echo "Nouveau stock : " . $produit->getStock() . "\n";

// Calcul du prix TTC
echo "Prix TTC : " . $produit->calculerPrixTTC() . "€\n";

// Vérification du stock
$quantiteDemandee = 8;
if ($produit->verifierStock($quantiteDemandee)) {
    echo "Le stock est suffisant pour une commande de $quantiteDemandee unités.\n";
} else {
    echo "Le stock est insuffisant pour une commande de $quantiteDemandee unités.\n";
}

echo "\n";

// Tests pour la classe Utilisateur
echo "--- Tests pour la classe Utilisateur ---\n";

// Utilisation de Client pour les tests du Jour 1
// Création d'un utilisateur
$utilisateur = new Client("Alice", "alice@example.com", "password123", "123 Rue du Test, Paris");

echo "Utilisateur créé : " . $utilisateur->getNom() . "\n";
echo "Email : " . $utilisateur->getEmail() . "\n";
echo "Date d'inscription : " . $utilisateur->getDateInscription()->format('Y-m-d H:i:s') . "\n";

// Vérification du mot de passe
if ($utilisateur->verifierMotDePasse("password123")) {
    echo "Le mot de passe est correct.\n";
} else {
    echo "Le mot de passe est incorrect.\n";
}

// Mise à jour du mot de passe
$utilisateur->mettreAJourProfil("Alice Dupont", "alice.dupont@example.com", "newpassword456");

echo "Profil mis à jour :\n";
echo "Nom : " . $utilisateur->getNom() . "\n";
echo "Email : " . $utilisateur->getEmail() . "\n";

// Vérification du nouveau mot de passe
if ($utilisateur->verifierMotDePasse("newpassword456")) {
    echo "Le nouveau mot de passe est correct.\n";
} else {
    echo "Le nouveau mot de passe est incorrect.\n";
}


echo "\n";

// === Jour 2 - Tests pour la hiérarchie des produits et le panier ===

echo "=== Jour 2 - Tests pour la hiérarchie des produits et le panier ===\n\n";

// Tests pour ProduitPhysique
echo "--- Tests pour ProduitPhysique ---\n";

$produitPhysique = new ProduitPhysique(
    "Chaise en bois",
    "Une chaise confortable en bois massif",
    150.00,
    20,
    7.5,  // poids en kg
    50.0, // longueur en cm
    45.0, // largeur en cm
    90.0  // hauteur en cm
);

$produitPhysique->afficherDetails();
echo "Volume : " . $produitPhysique->calculerVolume() . " cm³\n";
echo "Frais de livraison : " . $produitPhysique->calculerFraisLivraison() . "€\n\n";

// Tests pour ProduitNumerique
echo "--- Tests pour ProduitNumerique ---\n";

$produitNumerique = new ProduitNumerique(
    "E-book 'Apprendre PHP'",
    "Un livre numérique pour apprendre PHP",
    19.99,
    100,
    "https://exemple.com/telechargement/ebook-php",
    5.0,  // taille en MB
    "pdf"
);

$produitNumerique->afficherDetails();
echo "Lien de téléchargement : " . $produitNumerique->genererLienTelechargement() . "\n";
echo "Frais de livraison : " . $produitNumerique->calculerFraisLivraison() . "€\n\n";

// Tests pour ProduitPerissable
echo "--- Tests pour ProduitPerissable ---\n";

$produitPerissable = new ProduitPerissable(
    "Fromage artisanal",
    "Un fromage artisanal de qualité",
    25.00,
    50,
    new DateTime('2023-12-31'),
    4.0  // température de stockage en °C
);

$produitPerissable->afficherDetails();
echo "Le produit est-il périmé ? " . ($produitPerissable->estPerime() ? "Oui" : "Non") . "\n";
echo "Frais de livraison : " . $produitPerissable->calculerFraisLivraison() . "€\n\n";

// Tests pour le Panier
echo "--- Tests pour le Panier ---\n";

$panier = new Panier();

$panier->ajouterArticle($produitPhysique, 2);
$panier->ajouterArticle($produitNumerique, 1);
$panier->ajouterArticle($produitPerissable, 5);

echo "Nombre total d'articles dans le panier : " . $panier->compterArticles() . "\n";
echo "Total du panier : " . $panier->calculerTotal() . "€\n\n";

$panier->retirerArticle($produitPerissable, 2);
echo "Après retrait de 2 unités du produit périssable :\n";
echo "Nombre total d'articles dans le panier : " . $panier->compterArticles() . "\n";
echo "Total du panier : " . $panier->calculerTotal() . "€\n\n";

$panier->vider();
echo "Après vidage du panier :\n";
echo "Nombre total d'articles dans le panier : " . $panier->compterArticles() . "\n";
echo "Total du panier : " . $panier->calculerTotal() . "€\n\n";

// Tests pour les utilisateurs
echo "--- Tests pour les Utilisateurs ---\n";

// Création d'un client
$client = new Client("Bob", "bob@example.com", "clientpass", "123 Rue du Client, Paris");

echo "Client créé : " . $client->getNom() . "\n";
echo "Adresse de livraison : " . $client->getAdresseLivraison() . "\n";
$client->afficherRoles();

echo "\n";

// Création d'un administrateur
$admin = new Admin("Alice", "alice@example.com", "adminpass", 5);

echo "Administrateur créé : " . $admin->getNom() . "\n";
echo "Niveau d'accès : " . $admin->getNiveauAcces() . "\n";
$admin->afficherRoles();

echo "\n";

// Création d'un vendeur
$vendeur = new Vendeur("Charlie", "charlie@example.com", "vendeurpass", "Boutique de Charlie", 10.0);

echo "Vendeur créé : " . $vendeur->getNom() . "\n";
echo "Boutique : " . $vendeur->getBoutique() . "\n";
echo "Commission : " . $vendeur->getCommission() . "%\n";
$vendeur->afficherRoles();

echo "\n";

// === Jour 3 - Tests pour l'autoloading, la ProduitFactory, et le ConfigurationManager ===

echo "=== Jour 3 - Tests pour l'autoloading, la ProduitFactory, et le ConfigurationManager ===\n\n";

// Test de l'autoloading
echo "--- Test de l'autoloading ---\n";
echo "L'autoloading est configuré correctement.\n\n";

// Tests pour la ProduitFactory
echo "--- Tests pour la ProduitFactory ---\n";

try {
    $dataPhysique = [
        'nom' => 'Table en chêne',
        'description' => 'Une table solide en chêne massif',
        'prix' => 500.00,
        'stock' => 5,
        'poids' => 30.0,
        'longueur' => 200.0,
        'largeur' => 100.0,
        'hauteur' => 75.0,
    ];

    $tableChene = ProduitFactory::creerProduit('physique', $dataPhysique);
    $tableChene->afficherDetails();

    $dataNumerique = [
        'nom' => 'Album de musique',
        'description' => 'Un album de musique en format numérique',
        'prix' => 9.99,
        'stock' => 1000,
        'lienTelechargement' => 'https://exemple.com/telechargement/album',
        'tailleFichier' => 100.0,
        'formatFichier' => 'mp3',
    ];

    $albumMusique = ProduitFactory::creerProduit('numerique', $dataNumerique);
    $albumMusique->afficherDetails();
} catch (\Exception $e) {
    echo "Erreur lors de la création du produit : " . $e->getMessage() . "\n";
}

echo "\n";

// Tests pour le ConfigurationManager
echo "--- Tests pour le ConfigurationManager ---\n";

$configManager = ConfigurationManager::getInstance();

echo "TVA actuelle : " . $configManager->get('tva') . "%\n";
echo "Devise actuelle : " . $configManager->get('devise') . "\n";

$configManager->set('tva', 15);
echo "Nouvelle TVA : " . $configManager->get('tva') . "%\n";

$configManager->set('email_contact', 'support@example.com');
echo "Email de contact : " . $configManager->get('email_contact') . "\n";

echo "\n";

// === Jour 4 - Tests pour la connexion à la base de données et les repositories ===

echo "=== Jour 4 - Tests pour la connexion à la base de données et les repositories ===\n\n";

// Test de la connexion à la base de données
echo "--- Test de la connexion à la base de données ---\n";

try {
    $dbConnection = DatabaseConnection::getInstance();
    echo "Connexion à la base de données établie avec succès.\n";
} catch (\Exception $e) {
    echo "Erreur de connexion : " . $e->getMessage() . "\n";
    exit();
}

echo "\n";

// Tests pour ProduitRepository
echo "--- Tests pour ProduitRepository ---\n";

$produitRepository = new ProduitRepository();

try {
    // Création d'un produit
    $produit = new ProduitPhysique(
        "Lampe de bureau",
        "Une lampe de bureau LED",
        45.00,
        15,
        2.0,
        20.0,
        20.0,
        50.0
    );
    $idProduit = $produitRepository->create($produit);
    echo "Produit créé avec l'ID : $idProduit\n";

    // Lecture du produit
    $produitLu = $produitRepository->read($idProduit);
    echo "Produit lu : " . $produitLu->getNom() . "\n";

    // Mise à jour du produit
    $produitLu->setPrix(40.00);
    $produitRepository->update($produitLu);
    echo "Produit mis à jour avec le nouveau prix : " . $produitLu->getPrix() . "€\n";

    // Suppression du produit
    $produitRepository->delete($idProduit);
    echo "Produit supprimé.\n";
} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}

echo "\n";

// Tests pour UtilisateurRepository
echo "--- Tests pour UtilisateurRepository ---\n";
$utilisateurRepository = new UtilisateurRepository();

try {
    // Création d'un client
    $client = new Client("Sophie", "sophie" . uniqid() . "@example.com", "sophiepass", "456 Rue de la Paix, Lyon");
    $idClient = $utilisateurRepository->create($client);
    echo "Client créé avec l'ID : $idClient\n";

    // Lecture du client
    // Lecture du client
    $utilisateur = $utilisateurRepository->read($idClient);
    if ($utilisateur instanceof Client) {
        echo "Client : " . $utilisateur->getNom() . "\n";
    }

    // Lecture du client
    $utilisateur = $utilisateurRepository->read($idClient);

    if ($utilisateur instanceof Client) {
        /** @var Client $client */
        $client = $utilisateur;

        echo "Client : " . $client->getNom() . "\n";

        // Mise à jour du client
        $client->setAdresseLivraison("789 Avenue des Champs, Lyon");
        $utilisateurRepository->update($client);
        echo "Client mis à jour avec la nouvelle adresse : " . $client->getAdresseLivraison() . "\n";
    } else {
        echo "L'utilisateur n'est pas un client.\n";
    }

    // Suppression du client
    $utilisateurRepository->delete($idClient);
    echo "Client supprimé.\n";
} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}


echo "\n";

// Tests pour CategorieRepository
echo "--- Tests pour CategorieRepository ---\n";

$categorieRepository = new CategorieRepository();

try {
    // Création d'une catégorie
    $categorie = new Categorie("Livres", "Tous les livres disponibles");
    $idCategorie = $categorieRepository->create($categorie);
    echo "Catégorie créée avec l'ID : " . $categorie->getId() . "\n";

    // Lecture de la catégorie
    $categorieLu = $categorieRepository->read($idCategorie);
    echo "Catégorie lue : " . $categorieLu->getNom() . "\n";

    // Mise à jour de la catégorie
    $categorieLu->setDescription("Livres de tous genres");
    $categorieRepository->update($categorieLu);
    echo "Catégorie mise à jour avec la nouvelle description : " . $categorieLu->getDescription() . "\n";

    // Suppression de la catégorie
    $categorieRepository->delete($idCategorie);
    echo "Catégorie supprimée.\n";
} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}

echo "\n";

// === Tests terminés ===

echo "=== Tests terminés ===\n";
