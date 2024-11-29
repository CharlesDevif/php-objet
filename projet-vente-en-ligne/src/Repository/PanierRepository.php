<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class PanierRepository
{
    private \PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    public function creerPanier(int $utilisateurId): int
    {
        $sql = "INSERT INTO panier (utilisateur_id, date_creation) VALUES (:utilisateur_id, :date_creation)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':utilisateur_id', $utilisateurId);
        $stmt->bindValue(':date_creation', (new \DateTime())->format('Y-m-d H:i:s'));
        $stmt->execute();

        return (int)$this->connection->lastInsertId();
    }

    public function recupererPanierIdParUtilisateur(int $utilisateurId): ?int
    {
        $sql = "SELECT id FROM panier WHERE utilisateur_id = :utilisateur_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':utilisateur_id', $utilisateurId);
        $stmt->execute();
        $result = $stmt->fetchColumn();

        return $result ? (int)$result : null;
    }

    public function ajouterArticleAuPanier(int $panierId, int $produitId, int $quantite): void
    {
        $sql = "INSERT INTO panier_article (panier_id, produit_id, quantite) 
                VALUES (:panier_id, :produit_id, :quantite)
                ON DUPLICATE KEY UPDATE quantite = quantite + :quantite";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':panier_id', $panierId, \PDO::PARAM_INT);
        $stmt->bindValue(':produit_id', $produitId, \PDO::PARAM_INT);
        $stmt->bindValue(':quantite', $quantite, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function supprimerArticleDuPanier(int $panierId, int $produitId): void
    {
        $sql = "DELETE FROM panier_article WHERE panier_id = :panier_id AND produit_id = :produit_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':panier_id', $panierId, \PDO::PARAM_INT);
        $stmt->bindValue(':produit_id', $produitId, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function viderPanier(int $panierId): void
    {
        $sql = "DELETE FROM panier_article WHERE panier_id = :panier_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':panier_id', $panierId, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function recupererArticlesDuPanier(int $panierId): array
    {
        $sql = "
            SELECT p.id AS produit_id, p.nom, p.description, p.prix, pa.quantite 
            FROM produit p
            JOIN panier_article pa ON p.id = pa.produit_id
            WHERE pa.panier_id = :panier_id
        ";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':panier_id', $panierId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function mettreAJourQuantite(int $panierId, int $produitId, int $quantite): void
    {
        $sql = "UPDATE panier_article SET quantite = :quantite WHERE panier_id = :panier_id AND produit_id = :produit_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':panier_id', $panierId, \PDO::PARAM_INT);
        $stmt->bindValue(':produit_id', $produitId, \PDO::PARAM_INT);
        $stmt->bindValue(':quantite', $quantite, \PDO::PARAM_INT);
        $stmt->execute();
    }
}
