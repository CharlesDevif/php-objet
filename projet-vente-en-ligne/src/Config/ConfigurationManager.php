<?php

namespace App\Config;

class ConfigurationManager
{
    private static ?ConfigurationManager $instance = null;

    private array $config = [];

    /**
     * Constructeur privé pour empêcher l'instanciation directe.
     */
    private function __construct()
    {
        // Charger la configuration initiale
        $this->config = [
            'tva' => 20,
            'devise' => '€',
            'frais_livraison_base' => 5.0,
            'email_contact' => 'contact@exemple.com',
            'db_host' => getenv('DB_HOST'),
            'db_name' => getenv('DB_NAME'),
            'db_user' => getenv('DB_USER'),
            'db_password' => getenv('DB_PASSWORD'),
        ];
    }

    /**
     * Retourne l'instance unique de ConfigurationManager.
     *
     * @return ConfigurationManager
     */
    public static function getInstance(): ConfigurationManager
    {
        if (self::$instance === null) {
            self::$instance = new ConfigurationManager();
        }
        return self::$instance;
    }

    /**
     * Obtient la valeur d'un paramètre de configuration.
     *
     * @param string $key
     * @return mixed
     * @throws \InvalidArgumentException Si le paramètre n'existe pas.
     */
    public function get(string $key)
    {
        if (!array_key_exists($key, $this->config)) {
            throw new \InvalidArgumentException("Le paramètre '$key' n'existe pas.");
        }
        return $this->config[$key];
    }

    /**
     * Définit la valeur d'un paramètre de configuration.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     * @throws \InvalidArgumentException Si le paramètre n'existe pas ou si la valeur est invalide.
     */
    public function set(string $key, $value): void
    {
        if (!array_key_exists($key, $this->config)) {
            throw new \InvalidArgumentException("Le paramètre '$key' n'existe pas.");
        }

        // Validation des paramètres
        switch ($key) {
            case 'tva':
                if (!is_numeric($value) || $value < 0) {
                    throw new \InvalidArgumentException("La TVA doit être un nombre positif.");
                }
                break;
            case 'devise':
                if (!is_string($value) || empty($value)) {
                    throw new \InvalidArgumentException("La devise doit être une chaîne non vide.");
                }
                break;
            case 'frais_livraison_base':
                if (!is_numeric($value) || $value < 0) {
                    throw new \InvalidArgumentException("Les frais de livraison doivent être un nombre positif.");
                }
                break;
            case 'email_contact':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    throw new \InvalidArgumentException("L'email de contact n'est pas valide.");
                }
                break;
            default:
                throw new \InvalidArgumentException("Le paramètre '$key' n'est pas géré.");
        }

        $this->config[$key] = $value;
    }
}
