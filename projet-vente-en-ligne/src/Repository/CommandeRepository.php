<?php

namespace App\Repository;

use App\Database\DatabaseConnection;

class CommandeRepository
{
    private \PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    public function creerCommande(int $utilisateurId, float $total): int
    {
        $sql = "INSERT INTO commande (utilisateur_id, date_creation, total) 
                VALUES (:utilisateur_id, :date_creation, :total)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':utilisateur_id', $utilisateurId);
        $stmt->bindValue(':date_creation', (new \DateTime())->format('Y-m-d H:i:s'));
        $stmt->bindValue(':total', $total);
        $stmt->execute();

        return (int)$this->connection->lastInsertId();
    }

    public function ajouterArticlesCommande(int $commandeId, array $articles): void
    {
        $sql = "INSERT INTO commande_article (commande_id, produit_id, quantite, prix_unitaire) 
                VALUES (:commande_id, :produit_id, :quantite, :prix_unitaire)";
        $stmt = $this->connection->prepare($sql);

        foreach ($articles as $article) {
            $stmt->bindValue(':commande_id', $commandeId);
            $stmt->bindValue(':produit_id', $article['produit']->getId());
            $stmt->bindValue(':quantite', $article['quantite']);
            $stmt->bindValue(':prix_unitaire', $article['produit']->getPrix());
            $stmt->execute();
        }
    }

    public function recupererCommandesUtilisateur(int $utilisateurId): array
    {
        $sql = "SELECT * FROM commande WHERE utilisateur_id = :utilisateur_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':utilisateur_id', $utilisateurId);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function recupererCommandeParId(int $commandeId, int $utilisateurId): ?array
{
    $sql = "SELECT * FROM commande WHERE id = :commande_id AND utilisateur_id = :utilisateur_id";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':commande_id', $commandeId, \PDO::PARAM_INT);
    $stmt->bindValue(':utilisateur_id', $utilisateurId, \PDO::PARAM_INT);
    $stmt->execute();
    $commande = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$commande) {
        return null;
    }

    // Récupérer les articles associés à la commande
    $sql = "SELECT p.nom, ca.quantite, ca.prix_unitaire 
            FROM commande_article ca
            JOIN produit p ON ca.produit_id = p.id
            WHERE ca.commande_id = :commande_id";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':commande_id', $commandeId, \PDO::PARAM_INT);
    $stmt->execute();
    $articles = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $commande['articles'] = $articles;

    return $commande;
}

}
