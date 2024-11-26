<?php

namespace App\Entity\Produit;

use App\Config\ConfigurationManager;

/**
 * Produit périssable nécessitant des conditions de stockage.
 */
class ProduitPerissable extends Produit
{
    private \DateTime $dateExpiration;
    private float $temperatureStockage;

    public function __construct(
        string $nom,
        string $description,
        float $prix,
        int $stock,
        \DateTime $dateExpiration,
        float $temperatureStockage
    ) {
        parent::__construct($nom, $description, $prix, $stock);
        $this->dateExpiration = $dateExpiration;
        $this->temperatureStockage = $temperatureStockage;
    }

    // Getters et setters
    public function getDateExpiration(): \DateTime
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTime $dateExpiration): void
    {
        $this->dateExpiration = $dateExpiration;
    }

    public function getTemperatureStockage(): float
    {
        return $this->temperatureStockage;
    }

    public function setTemperatureStockage(float $temperatureStockage): void
    {
        $this->temperatureStockage = $temperatureStockage;
    }

    public function estPerime(): bool
    {
        return new \DateTime() > $this->dateExpiration;
    }

    public function calculerFraisLivraison(): float
    {
        $configManager = ConfigurationManager::getInstance();
        $fraisBase = $configManager->get('frais_livraison_base');
        return $fraisBase + 5;
    }

    public function afficherDetails(): void
    {
        echo "Produit périssable : {$this->getNom()}, Expire le : {$this->dateExpiration->format('Y-m-d')}.\n";
    }
}
