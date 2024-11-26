<?php

namespace App\Entity\Produit;

/**
 * Produit périssable nécessitant des conditions de stockage.
 */
class ProduitPerissable extends Produit
{
    private \DateTime $dateExpiration;
    private float $temperatureStockage;

    public function __construct(string $nom, string $description, float $prix, int $stock, \DateTime $dateExpiration, float $temperatureStockage)
    {
        parent::__construct($nom, $description, $prix, $stock);
        $this->dateExpiration = $dateExpiration;
        $this->temperatureStockage = $temperatureStockage;
    }

    public function estPerime(): bool
    {
        return new \DateTime() > $this->dateExpiration;
    }

    public function calculerFraisLivraison(): float
    {
        return 10 + 5;
    }

    public function afficherDetails(): void
    {
        echo "Produit périssable : {$this->getNom()}, Expire le : {$this->dateExpiration->format('Y-m-d')}.\n";
    }
}
