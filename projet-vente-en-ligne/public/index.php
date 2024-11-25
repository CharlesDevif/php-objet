<?php


require_once __DIR__ . '/../src/Entity/Produit.php';
require_once __DIR__ . '/../src/Entity/Utilisateur.php';

use App\Entity\Produit;
use App\Entity\Utilisateur;

// Création d'instances de produits
try {
    $produit1 = new Produit("Ordinateur Portable", "Un puissant ordinateur portable.", 1200.99, 10);
    $produit2 = new Produit("Smartphone", "Un smartphone dernier cri.", 799.49, 5);

    // Modification des propriétés via setters
    $produit1->setPrix(1150.00);
    $produit1->setStock(8);

    // Calcul de prix TTC
    echo "Prix TTC du produit 1 : " . $produit1->calculerPrixTTC() . "€\n";

    // Vérification de stock
    $quantiteDemandee = 9;
    if ($produit1->verifierStock($quantiteDemandee)) {
        echo "Le stock est suffisant pour $quantiteDemandee unités.\n";
    } else {
        echo "Le stock n'est pas suffisant pour $quantiteDemandee unités.\n";
    }
} catch (\Exception $e) {
    echo "Erreur lors de la création ou de la modification du produit : " . $e->getMessage() . "\n";
}

// Création d'instances d'utilisateurs
try {
    $utilisateur1 = new Utilisateur("Alice", "alice@example.com", "password123");
    $utilisateur2 = new Utilisateur("Bob", "bob@example.com", "securePass!");

    // Validation du mot de passe
    if ($utilisateur1->verifierMotDePasse("password123")) {
        echo "Mot de passe valide pour " . $utilisateur1->getNom() . ".\n";
    } else {
        echo "Mot de passe invalide pour " . $utilisateur1->getNom() . ".\n";
    }

    // Mise à jour de profil
    $utilisateur1->mettreAJourProfil("Alice Smith", "alice.smith@example.com", "newPassword456");
    echo "Profil mis à jour pour " . $utilisateur1->getNom() . ".\n";
} catch (\Exception $e) {
    echo "Erreur lors de la création ou de la modification de l'utilisateur : " . $e->getMessage() . "\n";
}
