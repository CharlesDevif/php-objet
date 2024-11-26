<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use App\Entity\Utilisateur\Utilisateur;
use App\Entity\Utilisateur\Client;
use App\Entity\Utilisateur\Admin;
use App\Entity\Utilisateur\Vendeur;
use PDO;

class UtilisateurRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    public function create(Utilisateur $utilisateur): int
    {
        $sql = "INSERT INTO utilisateur (nom, email, mot_de_passe, date_inscription, type, 
                adresse_livraison, niveau_acces, derniere_connexion, boutique, commission)
                VALUES (:nom, :email, :mot_de_passe, :date_inscription, :type, 
                :adresse_livraison, :niveau_acces, :derniere_connexion, :boutique, :commission)";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(':nom', $utilisateur->getNom());
        $stmt->bindValue(':email', $utilisateur->getEmail());
        $stmt->bindValue(':mot_de_passe', $utilisateur->getMotDePasse());
        $stmt->bindValue(':date_inscription', $utilisateur->getDateInscription()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':type', $this->getTypeUtilisateur($utilisateur));

        // Initialiser tous les champs spécifiques à NULL
        $stmt->bindValue(':adresse_livraison', null);
        $stmt->bindValue(':niveau_acces', null);
        $stmt->bindValue(':derniere_connexion', null);
        $stmt->bindValue(':boutique', null);
        $stmt->bindValue(':commission', null);

        // Liaison des champs spécifiques en fonction du type d'utilisateur
        if ($utilisateur instanceof Client) {
            $stmt->bindValue(':adresse_livraison', $utilisateur->getAdresseLivraison());
        } elseif ($utilisateur instanceof Admin) {
            $stmt->bindValue(':niveau_acces', $utilisateur->getNiveauAcces());
            $stmt->bindValue(':derniere_connexion', $utilisateur->getDerniereConnexion()->format('Y-m-d H:i:s'));
        } elseif ($utilisateur instanceof Vendeur) {
            $stmt->bindValue(':boutique', $utilisateur->getBoutique());
            $stmt->bindValue(':commission', $utilisateur->getCommission());
        }

        if ($stmt->execute()) {
            $id = (int)$this->connection->lastInsertId();
            $utilisateur->setId($id);
            return $id;
        } else {
            throw new \Exception('Erreur lors de la création de l\'utilisateur.');
        }
    }

    public function read(int $id): ?Utilisateur
    {
        $sql = "SELECT * FROM utilisateur WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $utilisateur = $this->hydraterUtilisateur($data);
            return $utilisateur;
        }

        return null;
    }

    public function update(Utilisateur $utilisateur): void
    {
        $sql = "UPDATE utilisateur SET nom = :nom, email = :email, mot_de_passe = :mot_de_passe, 
                date_inscription = :date_inscription, type = :type,
                adresse_livraison = :adresse_livraison, niveau_acces = :niveau_acces, 
                derniere_connexion = :derniere_connexion, boutique = :boutique, commission = :commission
                WHERE id = :id";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(':nom', $utilisateur->getNom());
        $stmt->bindValue(':email', $utilisateur->getEmail());
        $stmt->bindValue(':mot_de_passe', $utilisateur->getMotDePasse());
        $stmt->bindValue(':date_inscription', $utilisateur->getDateInscription()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':type', $this->getTypeUtilisateur($utilisateur));
        $stmt->bindValue(':id', $utilisateur->getId());

        // Initialiser tous les champs spécifiques à NULL
        $stmt->bindValue(':adresse_livraison', null);
        $stmt->bindValue(':niveau_acces', null);
        $stmt->bindValue(':derniere_connexion', null);
        $stmt->bindValue(':boutique', null);
        $stmt->bindValue(':commission', null);

        // Liaison des champs spécifiques en fonction du type d'utilisateur
        if ($utilisateur instanceof Client) {
            $stmt->bindValue(':adresse_livraison', $utilisateur->getAdresseLivraison());
        } elseif ($utilisateur instanceof Admin) {
            $stmt->bindValue(':niveau_acces', $utilisateur->getNiveauAcces());
            $stmt->bindValue(':derniere_connexion', $utilisateur->getDerniereConnexion()->format('Y-m-d H:i:s'));
        } elseif ($utilisateur instanceof Vendeur) {
            $stmt->bindValue(':boutique', $utilisateur->getBoutique());
            $stmt->bindValue(':commission', $utilisateur->getCommission());
        }

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour de l\'utilisateur.');
        }
    }

    public function delete(int $id): void
    {
        $sql = "DELETE FROM utilisateur WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la suppression de l\'utilisateur.');
        }
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM utilisateur";
        $stmt = $this->connection->query($sql);
        $utilisateurs = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $utilisateur = $this->hydraterUtilisateur($data);
            $utilisateurs[] = $utilisateur;
        }

        return $utilisateurs;
    }

    public function findBy(array $criteria): array
    {
        $sql = "SELECT * FROM utilisateur WHERE ";
        $conditions = [];
        $params = [];

        foreach ($criteria as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        $sql .= implode(' AND ', $conditions);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        $utilisateurs = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $utilisateur = $this->hydraterUtilisateur($data);
            $utilisateurs[] = $utilisateur;
        }

        return $utilisateurs;
    }

    private function hydraterUtilisateur(array $data): Utilisateur
    {
        $type = $data['type'];
        $utilisateur = null;

        switch ($type) {
            case 'client':
                $adresseLivraison = $data['adresse_livraison'] ?? '';
                $utilisateur = new Client(
                    $data['nom'],
                    $data['email'],
                    'mot_de_passe_temporaire',
                    $adresseLivraison
                );
                break;
            case 'admin':
                $niveauAcces = isset($data['niveau_acces']) ? (int)$data['niveau_acces'] : 0;
                $utilisateur = new Admin(
                    $data['nom'],
                    $data['email'],
                    'mot_de_passe_temporaire',
                    $niveauAcces
                );
                $derniereConnexion = isset($data['derniere_connexion']) ? new \DateTime($data['derniere_connexion']) : new \DateTime();
                $utilisateur->setDerniereConnexion($derniereConnexion);
                break;
            case 'vendeur':
                $boutique = $data['boutique'] ?? '';
                $commission = isset($data['commission']) ? (float)$data['commission'] : 0.0;
                $utilisateur = new Vendeur(
                    $data['nom'],
                    $data['email'],
                    'mot_de_passe_temporaire',
                    $boutique,
                    $commission
                );
                break;
            default:
                throw new \Exception("Type d'utilisateur inconnu : {$data['type']}");
        }

        $utilisateur->setId((int)$data['id']);
        $utilisateur->setDateInscription(new \DateTime($data['date_inscription']));
        $utilisateur->setMotDePasseHache($data['mot_de_passe']);

        return $utilisateur;
    }

    private function getTypeUtilisateur(Utilisateur $utilisateur): string
    {
        if ($utilisateur instanceof Client) {
            return 'client';
        } elseif ($utilisateur instanceof Admin) {
            return 'admin';
        } elseif ($utilisateur instanceof Vendeur) {
            return 'vendeur';
        } else {
            throw new \Exception('Type d\'utilisateur non reconnu.');
        }
    }
}
