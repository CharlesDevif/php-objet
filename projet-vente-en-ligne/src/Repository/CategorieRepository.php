<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use App\Entity\Categorie;
use PDO;

class CategorieRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    /**
     * Ajoute une nouvelle catégorie et retourne son ID.
     *
     * @param Categorie $categorie
     * @return int
     * @throws \Exception
     */
    public function create(Categorie $categorie): int
    {
        $sql = "INSERT INTO categorie (nom, description) VALUES (:nom, :description)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':nom', $categorie->getNom());
        $stmt->bindValue(':description', $categorie->getDescription());
    
        if ($stmt->execute()) {
            $id = (int)$this->connection->lastInsertId();
            $categorie->setId($id);
            return $id;
        } else {
            throw new \Exception('Erreur lors de la création de la catégorie.');
        }
    }
    

    /**
     * Récupère une catégorie par son ID.
     *
     * @param int $id
     * @return ?Categorie
     */
    public function read(int $id): ?Categorie
    {
        $sql = "SELECT * FROM categorie WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            $categorie = new Categorie(
                $data['nom'],
                $data['description'],
                (int)$data['id']
            );
            return $categorie;
        }

        return null;
    }

    /**
     * Met à jour une catégorie existante.
     *
     * @param Categorie $categorie
     * @return void
     * @throws \Exception
     */
    public function update(Categorie $categorie): void
    {
        $sql = "UPDATE categorie SET nom = :nom, description = :description WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':nom', $categorie->getNom());
        $stmt->bindValue(':description', $categorie->getDescription());
        $stmt->bindValue(':id', $categorie->getId());

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour de la catégorie.');
        }
    }

    public function ajouterProduitCategorie(int $produitId, int $categorieId): void
    {
        $sql = "INSERT INTO produit_categorie (produit_id, categorie_id) VALUES (:produit_id, :categorie_id)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':produit_id', $produitId, PDO::PARAM_INT);
        $stmt->bindValue(':categorie_id', $categorieId, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout du produit à la catégorie.');
        }
    }

    public function recupererProduitsParCategorie(int $categorieId): array
    {
        $sql = "
            SELECT p.*
            FROM produit p
            JOIN produit_categorie pc ON p.id = pc.produit_id
            WHERE pc.categorie_id = :categorie_id
        ";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':categorie_id', $categorieId, PDO::PARAM_INT);
        $stmt->execute();
    
        $produits = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            try {
                $produits[] = \App\Factory\ProduitFactory::creerProduit($data['type'], [
                    'nom' => $data['nom'],
                    'description' => $data['description'],
                    'prix' => (float)$data['prix'],
                    'stock' => (int)$data['stock'],
                    'id' => (int)$data['id'],
                    // Ajoutez ici les champs spécifiques à chaque type
                    'poids' => $data['poids'] ?? null,
                    'longueur' => $data['longueur'] ?? null,
                    'largeur' => $data['largeur'] ?? null,
                    'hauteur' => $data['hauteur'] ?? null,
                    'lienTelechargement' => $data['lienTelechargement'] ?? null,
                    'tailleFichier' => $data['tailleFichier'] ?? null,
                    'formatFichier' => $data['formatFichier'] ?? null,
                    'dateExpiration' => $data['dateExpiration'] ?? null,
                    'temperatureStockage' => $data['temperatureStockage'] ?? null,
                ]);
            } catch (\Exception $e) {
                // Gérer l'exception si un produit ne peut pas être créé
                throw new \RuntimeException('Erreur lors de la création du produit : ' . $e->getMessage());
            }
        }
    
        return $produits;
    }

    public function supprimerProduitCategorie(int $produitId, int $categorieId): void
{
    $sql = "DELETE FROM produit_categorie WHERE produit_id = :produit_id AND categorie_id = :categorie_id";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':produit_id', $produitId, PDO::PARAM_INT);
    $stmt->bindValue(':categorie_id', $categorieId, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        throw new \Exception("Erreur lors de la suppression du produit de la catégorie.");
    }
}

    


    /**
     * Supprime une catégorie par son ID.
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM categorie WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la suppression de la catégorie.');
        }
    }

    /**
     * Récupère toutes les catégories.
     *
     * @return array
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM categorie";
        $stmt = $this->connection->query($sql);
        $categories = [];
        while ($data = $stmt->fetch()) {
            $categorie = new Categorie(
                $data['nom'],
                $data['description'],
                (int)$data['id']
            );
            $categories[] = $categorie;
        }

        return $categories;
    }

    /**
     * Recherche des catégories selon des critères spécifiques.
     *
     * @param array $criteria
     * @return array
     */
    public function findBy(array $criteria): array
    {
        $sql = "SELECT * FROM categorie WHERE ";
        $conditions = [];
        $params = [];

        foreach ($criteria as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        $sql .= implode(' AND ', $conditions);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        $categories = [];

        while ($data = $stmt->fetch()) {
            $categorie = new Categorie(
                $data['nom'],
                $data['description'],
                (int)$data['id']
            );
            $categories[] = $categorie;
        }

        return $categories;
    }
}
