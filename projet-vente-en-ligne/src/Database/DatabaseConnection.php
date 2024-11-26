<?php

namespace App\Database;

use PDO;
use PDOException;

class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private PDO $connection;

    /**
     * Constructeur privé pour empêcher l'instanciation directe.
     */
    private function __construct()
    {
        try {
            // Obtenir les paramètres de connexion depuis le ConfigurationManager
            $configManager = \App\Config\ConfigurationManager::getInstance();
            $host = $configManager->get('db_host');
            $dbname = $configManager->get('db_name');
            $user = $configManager->get('db_user');
            $password = $configManager->get('db_password');

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT         => false,
            ];

            $this->connection = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            // Lever une exception en cas de problème de connexion
            throw new \Exception('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    /**
     * Retourne l'instance unique de DatabaseConnection.
     *
     * @return DatabaseConnection
     */
    public static function getInstance(): DatabaseConnection
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    /**
     * Retourne l'instance PDO pour les requêtes.
     *
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
