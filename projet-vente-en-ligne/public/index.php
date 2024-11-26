<?php

// Inclure les fichiers de classe ou utiliser un autoloader
require_once __DIR__ . '/../src/Entity/Produit/Produit.php';
require_once __DIR__ . '/../src/Entity/Produit/ProduitPhysique.php';
require_once __DIR__ . '/../src/Entity/Produit/ProduitNumerique.php';
require_once __DIR__ . '/../src/Entity/Produit/ProduitPerissable.php';
require_once __DIR__ . '/../src/Entity/Categorie.php';
require_once __DIR__ . '/../src/Entity/Panier.php';
require_once __DIR__ . '/../src/Entity/Utilisateur/Utilisateur.php';
require_once __DIR__ . '/../src/Entity/Utilisateur/Client.php';
require_once __DIR__ . '/../src/Entity/Utilisateur/Admin.php';
require_once __DIR__ . '/../src/Entity/Utilisateur/Vendeur.php';

// Si vous utilisez des namespaces, vous pouvez les importer
use App\Entity\Produit\ProduitPhysique;
use App\Entity\Produit\ProduitNumerique;
use App\Entity\Produit\ProduitPerissable;
use App\Entity\Categorie;
use App\Entity\Panier;
use App\Entity\Utilisateur\Client;
use App\Entity\Utilisateur\Admin;
use App\Entity\Utilisateur\Vendeur;

echo "=== Création de différents types de produits ===\n";

// Création d'un produit physique
$produitPhysique = new ProduitPhysique(
    "Laptop",
    "Un ordinateur portable performant.",
    1500.00,
    5,
    2.5,   // poids en kg
    35.0,  // longueur en cm
    24.0,  // largeur en cm
    2.0    // hauteur en cm
);

$produitPhysique->afficherDetails();
echo "Frais de livraison : " . $produitPhysique->calculerFraisLivraison() . "€\n\n";

// Création d'un produit numérique
$produitNumerique = new ProduitNumerique(
    "E-book PHP",
    "Un livre électronique pour apprendre PHP.",
    29.99,
    100,
    "https://exemple.com/telechargement/ebook-php",
    5.0,   // taille du fichier en MB
    "PDF"
);

$produitNumerique->afficherDetails();
echo "Frais de livraison : " . $produitNumerique->calculerFraisLivraison() . "€\n";
echo "Lien de téléchargement : " . $produitNumerique->genererLienTelechargement() . "\n\n";

// Création d'un produit périssable
$dateExpiration = new \DateTime('+5 days');
$produitPerissable = new ProduitPerissable(
    "Yaourt",
    "Un yaourt bio.",
    1.50,
    50,
    $dateExpiration,
    4.0   // température de stockage en °C
);

$produitPerissable->afficherDetails();
echo "Est périmé ? " . ($produitPerissable->estPerime() ? "Oui" : "Non") . "\n";
echo "Frais de livraison : " . $produitPerissable->calculerFraisLivraison() . "€\n\n";

echo "=== Manipulation du panier ===\n";

$panier = new Panier();
$panier->ajouterArticle($produitPhysique, 2);
$panier->ajouterArticle($produitNumerique, 1);
$panier->ajouterArticle($produitPerissable, 10);

echo "Total du panier : " . $panier->calculerTotal() . "€\n";
echo "Nombre d'articles dans le panier : " . $panier->compterArticles() . "\n";

$panier->retirerArticle($produitPerissable, 5);
echo "Après avoir retiré 5 yaourts :\n";
echo "Total du panier : " . $panier->calculerTotal() . "€\n";
echo "Nombre d'articles dans le panier : " . $panier->compterArticles() . "\n";

$panier->vider();
echo "Après avoir vidé le panier :\n";
echo "Total du panier : " . $panier->calculerTotal() . "€\n";
echo "Nombre d'articles dans le panier : " . $panier->compterArticles() . "\n\n";

echo "=== Création et gestion des différents types d'utilisateurs ===\n";

// Création d'un client
$client = new Client("Alice", "alice@example.com", "password123", "123 Rue Principale, Paris");
$client->afficherRoles();
echo "Adresse de livraison : " . $client->getAdresseLivraison() . "\n";

// Le client ajoute des articles à son panier
$client->getPanier()->ajouterArticle($produitPhysique, 1);
echo "Total du panier du client : " . $client->getPanier()->calculerTotal() . "€\n";

// Création d'un administrateur
$admin = new Admin("Bob", "bob@example.com", "adminpass456", 5);
$admin->afficherRoles();
echo "Niveau d'accès : " . $admin->getNiveauAcces() . "\n";

// Création d'un vendeur
$vendeur = new Vendeur("Charlie", "charlie@example.com", "vendpass789", "La Boutique de Charlie", 10.0);
$vendeur->afficherRoles();
echo "Boutique : " . $vendeur->getBoutique() . "\n";
echo "Commission : " . $vendeur->getCommission() . "%\n";

// Le vendeur ajoute un produit (fonctionnalité à implémenter)
$vendeur->ajouterProduit($produitPhysique);

