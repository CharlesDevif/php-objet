<?php

namespace App\Entity\Produit;

use App\Config\ConfigurationManager;

/**
 * Produit physique avec des propriétés liées à ses dimensions et son poids.
 */
class ProduitPhysique extends Produit
{
    private float $poids;
    private float $longueur;
    private float $largeur;
    private float $hauteur;

    public function __construct(
        string $nom,
        string $description,
        float $prix,
        int $stock,
        float $poids,
        float $longueur,
        float $largeur,
        float $hauteur
    ) {
        parent::__construct($nom, $description, $prix, $stock);
        $this->poids = $poids;
        $this->longueur = $longueur;
        $this->largeur = $largeur;
        $this->hauteur = $hauteur;
    }

    // Getters et setters
    public function getPoids(): float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): void
    {
        $this->poids = $poids;
    }

    public function getLongueur(): float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): void
    {
        $this->longueur = $longueur;
    }

    public function getLargeur(): float
    {
        return $this->largeur;
    }

    public function setLargeur(float $largeur): void
    {
        $this->largeur = $largeur;
    }

    public function getHauteur(): float
    {
        return $this->hauteur;
    }

    public function setHauteur(float $hauteur): void
    {
        $this->hauteur = $hauteur;
    }

    public function calculerVolume(): float
    {
        return $this->longueur * $this->largeur * $this->hauteur;
    }

    public function calculerFraisLivraison(): float
    {
        $configManager = ConfigurationManager::getInstance();
        $fraisBase = $configManager->get('frais_livraison_base');
        $fraisLivraison = $fraisBase + ($this->poids * 1.5); 

        return $fraisLivraison;
    }

    public function afficherDetails(): void
    {
        echo "Produit physique : {$this->getNom()}, Poids : {$this->poids}kg, Volume : {$this->calculerVolume()} cm³.\n";
    }
}
