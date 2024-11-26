-- Créer la base de données
CREATE DATABASE IF NOT EXISTS projet_vente_en_ligne CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE projet_vente_en_ligne;

-- Table 'categorie'
CREATE TABLE IF NOT EXISTS categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);

-- Table 'produit'
CREATE TABLE IF NOT EXISTS produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    type ENUM('physique', 'numerique', 'perissable') NOT NULL,
    -- Champs supplémentaires pour 'ProduitPhysique'
    poids FLOAT NULL,
    longueur FLOAT NULL,
    largeur FLOAT NULL,
    hauteur FLOAT NULL,
    -- Champs supplémentaires pour 'ProduitNumerique'
    lien_telechargement VARCHAR(255) NULL,
    taille_fichier FLOAT NULL,
    format_fichier VARCHAR(50) NULL,
    -- Champs supplémentaires pour 'ProduitPerissable'
    date_expiration DATE NULL,
    temperature_stockage FLOAT NULL
);

-- Table 'utilisateur'
CREATE TABLE IF NOT EXISTS utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription DATETIME NOT NULL,
    type ENUM('client', 'admin', 'vendeur') NOT NULL,
    -- Champs pour 'Client'
    adresse_livraison TEXT NULL,
    -- Champs pour 'Admin'
    niveau_acces INT NULL,
    derniere_connexion DATETIME NULL,
    -- Champs pour 'Vendeur'
    boutique VARCHAR(255) NULL,
    commission DECIMAL(5,2) NULL
);

-- Table 'produit_categorie' (relation Many-to-Many entre 'produit' et 'categorie')
CREATE TABLE IF NOT EXISTS produit_categorie (
    produit_id INT NOT NULL,
    categorie_id INT NOT NULL,
    PRIMARY KEY (produit_id, categorie_id),
    FOREIGN KEY (produit_id) REFERENCES produit(id) ON DELETE CASCADE,
    FOREIGN KEY (categorie_id) REFERENCES categorie(id) ON DELETE CASCADE
);

-- Table 'panier'
CREATE TABLE IF NOT EXISTS panier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    date_creation DATETIME NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
);

-- Table 'panier_article' (Articles dans un 'panier')
CREATE TABLE IF NOT EXISTS panier_article (
    panier_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    PRIMARY KEY (panier_id, produit_id),
    FOREIGN KEY (panier_id) REFERENCES panier(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produit(id) ON DELETE CASCADE
);
