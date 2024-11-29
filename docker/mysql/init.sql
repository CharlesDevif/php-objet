-- Créer la base de données
CREATE DATABASE IF NOT EXISTS projet_vente_en_ligne CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE projet_vente_en_ligne;

START TRANSACTION;

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
    -- Champs spécifiques à ProduitPhysique
    poids FLOAT NULL,
    longueur FLOAT NULL,
    largeur FLOAT NULL,
    hauteur FLOAT NULL,
    -- Champs spécifiques à ProduitNumerique
    lienTelechargement VARCHAR(255) NULL,
    tailleFichier FLOAT NULL,
    formatFichier VARCHAR(50) NULL,
    -- Champs spécifiques à ProduitPerissable
    dateExpiration DATE NULL,
    temperatureStockage FLOAT NULL
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

CREATE TABLE IF NOT EXISTS commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    date_creation DATETIME NOT NULL,
    etat ENUM('en_cours', 'en_preparation', 'expediee', 'livree') DEFAULT 'en_cours',
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)
);

CREATE TABLE IF NOT EXISTS commande_article (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commande(id),
    FOREIGN KEY (produit_id) REFERENCES produit(id)
);

INSERT INTO produit (nom, description, prix, stock, type, poids, longueur, largeur, hauteur, lienTelechargement, tailleFichier, formatFichier, dateExpiration, temperatureStockage)
VALUES
-- Produits physiques
('Laptop Pro 2023', 'Un ordinateur portable haut de gamme.', 1499.99, 10, 'physique', 1.5, 35.0, 24.0, 2.0, NULL, NULL, NULL, NULL, NULL),
('Casque Audio', 'Casque audio Bluetooth avec réduction de bruit.', 199.99, 25, 'physique', 0.3, 18.0, 16.0, 10.0, NULL, NULL, NULL, NULL, NULL),
('Smartphone X', 'Smartphone dernière génération avec écran OLED.', 999.99, 50, 'physique', 0.2, 15.0, 7.0, 0.8, NULL, NULL, NULL, NULL, NULL),

-- Produits numériques
('E-book Python', 'Guide complet pour apprendre Python.', 19.99, 100, 'numerique', NULL, NULL, NULL, NULL, 'https://example.com/ebooks/python-guide', 2.5, 'pdf', NULL, NULL),
('Logiciel Pro', 'Licence pour un logiciel professionnel.', 299.99, 500, 'numerique', NULL, NULL, NULL, NULL, 'https://example.com/software/license', 0.1, 'exe', NULL, NULL),

-- Produits périssables
('Lait Frais', 'Bouteille de lait frais (1 litre).', 1.99, 200, 'perissable', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-31', 4.0),
('Fromage Brie', 'Fromage Brie français.', 6.49, 50, 'perissable', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-30', 8.0),
('Jus d\'Orange', 'Jus d\'orange bio 100% pur jus.', 3.99, 100, 'perissable', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-03-15', 4.0);

COMMIT;