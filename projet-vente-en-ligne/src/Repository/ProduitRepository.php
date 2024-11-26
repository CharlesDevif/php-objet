<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use App\Entity\Produit\Produit;
use PDO;

class ProduitRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    /**
     * Ajoute un nouveau produit et retourne son ID.
     *
     * @param Produit $produit
     * @return int
     * @throws \Exception
     */
    public function create(Produit $produit): int
    {
        $sql = "INSERT INTO produit (nom, description, prix, stock) VALUES (:nom, :description, :prix, :stock)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':nom', $produit->getNom());
        $stmt->bindValue(':description', $produit->getDescription());
        $stmt->bindValue(':prix', $produit->getPrix());
        $stmt->bindValue(':stock', $produit->getStock());

        if ($stmt->execute()) {
            return (int)$this->connection->lastInsertId();
        } else {
            throw new \Exception('Erreur lors de la création du produit.');
        }
    }

    /**
     * Récupère un produit par son ID.
     *
     * @param int $id
     * @return ?Produit
     */
    public function read(int $id): ?Produit
    {
        $sql = "SELECT * FROM produit WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            // Vous pouvez utiliser la factory ou créer une méthode pour hydrater l'entité
            $produit = new Produit($data['nom'], $data['description'], (float)$data['prix'], (int)$data['stock']);
            // Assignez l'ID au produit
            $reflection = new \ReflectionClass($produit);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($produit, $data['id']);
            return $produit;
        }

        return null;
    }

    /**
     * Met à jour un produit existant.
     *
     * @param Produit $produit
     * @return void
     * @throws \Exception
     */
    public function update(Produit $produit): void
    {
        $sql = "UPDATE produit SET nom = :nom, description = :description, prix = :prix, stock = :stock WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':nom', $produit->getNom());
        $stmt->bindValue(':description', $produit->getDescription());
        $stmt->bindValue(':prix', $produit->getPrix());
        $stmt->bindValue(':stock', $produit->getStock());
        $stmt->bindValue(':id', $produit->getId());

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour du produit.');
        }
    }

    /**
     * Supprime un produit par son ID.
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM produit WHERE id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':id', $id);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la suppression du produit.');
        }
    }

    /**
     * Récupère tous les produits.
     *
     * @return array
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM produit";
        $stmt = $this->connection->query($sql);
        $produits = [];

        while ($data = $stmt->fetch()) {
            $produit = new Produit($data['nom'], $data['description'], (float)$data['prix'], (int)$data['stock']);
            // Assignez l'ID au produit
            $reflection = new \ReflectionClass($produit);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($produit, $data['id']);
            $produits[] = $produit;
        }

        return $produits;
    }

    /**
     * Recherche des produits selon des critères spécifiques.
     *
     * @param array $criteria
     * @return array
     */
    public function findBy(array $criteria): array
    {
        $sql = "SELECT * FROM produit WHERE ";
        $conditions = [];
        $params = [];

        foreach ($criteria as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        $sql .= implode(' AND ', $conditions);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        $produits = [];

        while ($data = $stmt->fetch()) {
            $produit = new Produit($data['nom'], $data['description'], (float)$data['prix'], (int)$data['stock']);
            // Assignez l'ID au produit
            $reflection = new \ReflectionClass($produit);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($produit, $data['id']);
            $produits[] = $produit;
        }

        return $produits;
    }
}
