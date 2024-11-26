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

    /**
     * Ajoute un nouvel utilisateur et retourne son ID.
     *
     * @param Utilisateur $utilisateur
     * @return int
     * @throws \Exception
     */
    public function create(Utilisateur $utilisateur): int
    {
        $sql = "INSERT INTO utilisateur (nom, email, mot_de_passe, date_inscription, type) VALUES (:nom, :email, :mot_de_passe, :date_inscription, :type)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':nom', $utilisateur->getNom());
        $stmt->bindValue(':email', $utilisateur->getEmail());
        $stmt->bindValue(':mot_de_passe', $utilisateur->getMotDePasse());
        $stmt->bindValue(':date_inscription', $utilisateur->getDateInscription()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':type', $this->getTypeUtilisateur($utilisateur));

        if ($stmt->execute()) {
            return (int)$this->connection->lastInsertId();
        } else {
            throw new \Exception('Erreur lors de la création de l\'utilisateur.');
        }
    }

    /**
     * Récupère un utilisateur par son ID.
     *
     * @param int $id
     * @return ?Utilisateur
     */
    public function read(int $id): ?Utilisateur
    {
        $sql = "SELECT * FROM utilisateur WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            $utilisateur = $this->hydraterUtilisateur($data);
            return $utilisateur;
        }

        return null;
    }

    /**
     * Met à jour un utilisateur existant.
     *
     * @param Utilisateur $utilisateur
     * @return void
     * @throws \Exception
     */
    public function update(Utilisateur $utilisateur): void
    {
        $sql = "UPDATE utilisateur SET nom = :nom, email = :email, mot_de_passe = :mot_de_passe, date_inscription = :date_inscription WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':nom', $utilisateur->getNom());
        $stmt->bindValue(':email', $utilisateur->getEmail());
        $stmt->bindValue(':mot_de_passe', $utilisateur->getMotDePasse());
        $stmt->bindValue(':date_inscription', $utilisateur->getDateInscription()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':id', $utilisateur->getId());

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour de l\'utilisateur.');
        }
    }

    /**
     * Supprime un utilisateur par son ID.
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM utilisateur WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la suppression de l\'utilisateur.');
        }
    }

    /**
     * Récupère tous les utilisateurs.
     *
     * @return array
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM utilisateur";
        $stmt = $this->connection->query($sql);
        $utilisateurs = [];

        while ($data = $stmt->fetch()) {
            $utilisateur = $this->hydraterUtilisateur($data);
            $utilisateurs[] = $utilisateur;
        }

        return $utilisateurs;
    }

    /**
     * Recherche des utilisateurs selon des critères spécifiques.
     *
     * @param array $criteria
     * @return array
     */
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

        while ($data = $stmt->fetch()) {
            $utilisateur = $this->hydraterUtilisateur($data);
            $utilisateurs[] = $utilisateur;
        }

        return $utilisateurs;
    }

    /**
     * Hydrate un utilisateur à partir des données de la base de données.
     *
     * @param array $data
     * @return Utilisateur
     */
    private function hydraterUtilisateur(array $data): Utilisateur
    {
        $type = $data['type'];
        $utilisateur = null;

        switch ($type) {
            case 'client':
                $utilisateur = new Client(
                    $data['nom'],
                    $data['email'],
                    $data['mot_de_passe'],
                    $data['adresse_livraison'] ?? ''
                );
                break;
            case 'admin':
                $utilisateur = new Admin(
                    $data['nom'],
                    $data['email'],
                    $data['mot_de_passe'],
                    $data['niveau_acces'] ?? 0
                );
                break;
            case 'vendeur':
                $utilisateur = new Vendeur(
                    $data['nom'],
                    $data['email'],
                    $data['mot_de_passe'],
                    $data['boutique'] ?? '',
                    $data['commission'] ?? 0.0
                );
                break;
            default:
                throw new \Exception("Type d'utilisateur inconnu : $type");
        }

        // Assigner l'ID et la date d'inscription
        $reflection = new \ReflectionClass($utilisateur);

        // ID
        $propertyId = $reflection->getParentClass()->getProperty('id');
        $propertyId->setAccessible(true);
        $propertyId->setValue($utilisateur, $data['id']);

        // Date d'inscription
        $propertyDate = $reflection->getParentClass()->getProperty('dateInscription');
        $propertyDate->setAccessible(true);
        $propertyDate->setValue($utilisateur, new \DateTime($data['date_inscription']));

        // Autres propriétés spécifiques
        if ($utilisateur instanceof Client) {
            $utilisateur->setAdresseLivraison($data['adresse_livraison'] ?? '');
        } elseif ($utilisateur instanceof Admin) {
            $utilisateur->setNiveauAcces($data['niveau_acces'] ?? 0);
            $utilisateur->setDerniereConnexion(new \DateTime($data['derniere_connexion'] ?? 'now'));
        } elseif ($utilisateur instanceof Vendeur) {
            $utilisateur->setBoutique($data['boutique'] ?? '');
            $utilisateur->setCommission($data['commission'] ?? 0.0);
        }

        return $utilisateur;
    }

    /**
     * Retourne le type d'utilisateur sous forme de chaîne.
     *
     * @param Utilisateur $utilisateur
     * @return string
     */
    private function getTypeUtilisateur(Utilisateur $utilisateur): string
    {
        if ($utilisateur instanceof Client) {
            return 'client';
        } elseif ($utilisateur instanceof Admin) {
            return 'admin';
        } elseif ($utilisateur instanceof Vendeur) {
            return 'vendeur';
        } else {
            return 'utilisateur';
        }
    }
}
