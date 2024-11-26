<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use App\Entity\Produit\Produit;
use App\Entity\Produit\ProduitPhysique;
use App\Entity\Produit\ProduitNumerique;
use App\Entity\Produit\ProduitPerissable;
use PDO;

class ProduitRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    public function create(Produit $produit): int
    {
        $sql = "INSERT INTO produit (nom, description, prix, stock, type, poids, longueur, largeur, hauteur, lienTelechargement, tailleFichier, formatFichier, dateExpiration, temperatureStockage)
                VALUES (:nom, :description, :prix, :stock, :type, :poids, :longueur, :largeur, :hauteur, :lienTelechargement, :tailleFichier, :formatFichier, :dateExpiration, :temperatureStockage)";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(':nom', $produit->getNom());
        $stmt->bindValue(':description', $produit->getDescription());
        $stmt->bindValue(':prix', $produit->getPrix());
        $stmt->bindValue(':stock', $produit->getStock());
        $stmt->bindValue(':type', $this->getTypeProduit($produit));

        // Initialiser tous les champs spécifiques à NULL
        $stmt->bindValue(':poids', null);
        $stmt->bindValue(':longueur', null);
        $stmt->bindValue(':largeur', null);
        $stmt->bindValue(':hauteur', null);
        $stmt->bindValue(':lienTelechargement', null);
        $stmt->bindValue(':tailleFichier', null);
        $stmt->bindValue(':formatFichier', null);
        $stmt->bindValue(':dateExpiration', null);
        $stmt->bindValue(':temperatureStockage', null);

        // Liaison des champs spécifiques en fonction du type de produit
        if ($produit instanceof ProduitPhysique) {
            $stmt->bindValue(':poids', $produit->getPoids());
            $stmt->bindValue(':longueur', $produit->getLongueur());
            $stmt->bindValue(':largeur', $produit->getLargeur());
            $stmt->bindValue(':hauteur', $produit->getHauteur());
        } elseif ($produit instanceof ProduitNumerique) {
            $stmt->bindValue(':lienTelechargement', $produit->getLienTelechargement());
            $stmt->bindValue(':tailleFichier', $produit->getTailleFichier());
            $stmt->bindValue(':formatFichier', $produit->getFormatFichier());
        } elseif ($produit instanceof ProduitPerissable) {
            $stmt->bindValue(':dateExpiration', $produit->getDateExpiration()->format('Y-m-d'));
            $stmt->bindValue(':temperatureStockage', $produit->getTemperatureStockage());
        }

        if ($stmt->execute()) {
            return (int)$this->connection->lastInsertId();
        } else {
            throw new \Exception('Erreur lors de la création du produit.');
        }
    }

    public function read(int $id): ?Produit
    {
        $sql = "SELECT * FROM produit WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            $produit = $this->hydraterProduit($data);
            return $produit;
        }

        return null;
    }

    public function update(Produit $produit): void
    {
        $sql = "UPDATE produit SET nom = :nom, description = :description, prix = :prix, stock = :stock, type = :type,
                poids = :poids, longueur = :longueur, largeur = :largeur, hauteur = :hauteur,
                lienTelechargement = :lienTelechargement, tailleFichier = :tailleFichier, formatFichier = :formatFichier,
                dateExpiration = :dateExpiration, temperatureStockage = :temperatureStockage
                WHERE id = :id";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(':nom', $produit->getNom());
        $stmt->bindValue(':description', $produit->getDescription());
        $stmt->bindValue(':prix', $produit->getPrix());
        $stmt->bindValue(':stock', $produit->getStock());
        $stmt->bindValue(':type', $this->getTypeProduit($produit));
        $stmt->bindValue(':id', $produit->getId());

        // Initialiser tous les champs spécifiques à NULL
        $stmt->bindValue(':poids', null);
        $stmt->bindValue(':longueur', null);
        $stmt->bindValue(':largeur', null);
        $stmt->bindValue(':hauteur', null);
        $stmt->bindValue(':lienTelechargement', null);
        $stmt->bindValue(':tailleFichier', null);
        $stmt->bindValue(':formatFichier', null);
        $stmt->bindValue(':dateExpiration', null);
        $stmt->bindValue(':temperatureStockage', null);

        // Liaison des champs spécifiques en fonction du type de produit
        if ($produit instanceof ProduitPhysique) {
            $stmt->bindValue(':poids', $produit->getPoids());
            $stmt->bindValue(':longueur', $produit->getLongueur());
            $stmt->bindValue(':largeur', $produit->getLargeur());
            $stmt->bindValue(':hauteur', $produit->getHauteur());
        } elseif ($produit instanceof ProduitNumerique) {
            $stmt->bindValue(':lienTelechargement', $produit->getLienTelechargement());
            $stmt->bindValue(':tailleFichier', $produit->getTailleFichier());
            $stmt->bindValue(':formatFichier', $produit->getFormatFichier());
        } elseif ($produit instanceof ProduitPerissable) {
            $stmt->bindValue(':dateExpiration', $produit->getDateExpiration()->format('Y-m-d'));
            $stmt->bindValue(':temperatureStockage', $produit->getTemperatureStockage());
        }

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour du produit.');
        }
    }

    public function delete(int $id): void
    {
        $sql = "DELETE FROM produit WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la suppression du produit.');
        }
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM produit";
        $stmt = $this->connection->query($sql);
        $produits = [];

        while ($data = $stmt->fetch()) {
            $produit = $this->hydraterProduit($data);
            $produits[] = $produit;
        }

        return $produits;
    }

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
            $produit = $this->hydraterProduit($data);
            $produits[] = $produit;
        }

        return $produits;
    }

    private function hydraterProduit(array $data): Produit
    {
        $type = $data['type'];
        $produit = null;

        switch ($type) {
            case 'physique':
                $produit = new ProduitPhysique(
                    $data['nom'],
                    $data['description'],
                    (float)$data['prix'],
                    (int)$data['stock'],
                    (float)$data['poids'],
                    (float)$data['longueur'],
                    (float)$data['largeur'],
                    (float)$data['hauteur']
                );
                break;
            case 'numerique':
                $produit = new ProduitNumerique(
                    $data['nom'],
                    $data['description'],
                    (float)$data['prix'],
                    (int)$data['stock'],
                    $data['lienTelechargement'],
                    (float)$data['tailleFichier'],
                    $data['formatFichier']
                );
                break;
            case 'perissable':
                $produit = new ProduitPerissable(
                    $data['nom'],
                    $data['description'],
                    (float)$data['prix'],
                    (int)$data['stock'],
                    new \DateTime($data['dateExpiration']),
                    (float)$data['temperatureStockage']
                );
                break;
            default:
                throw new \Exception("Type de produit inconnu : $type");
        }

        // Assigner l'ID
        $produit->setId((int)$data['id']);

        return $produit;
    }

    private function getTypeProduit(Produit $produit): string
    {
        if ($produit instanceof ProduitPhysique) {
            return 'physique';
        } elseif ($produit instanceof ProduitNumerique) {
            return 'numerique';
        } elseif ($produit instanceof ProduitPerissable) {
            return 'perissable';
        } else {
            throw new \Exception('Type de produit non reconnu.');
        }
    }
}
