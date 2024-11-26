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
            return (int)$this->connection->lastInsertId();
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
            $categorie = new Categorie($data['id'], $data['nom'], $data['description']);
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
            $categorie = new Categorie($data['id'], $data['nom'], $data['description']);
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
            $categorie = new Categorie($data['id'], $data['nom'], $data['description']);
            $categories[] = $categorie;
        }

        return $categories;
    }
}
