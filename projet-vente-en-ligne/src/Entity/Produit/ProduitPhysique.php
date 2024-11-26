<?php

namespace App\Entity\Produit;

/**
 * Produit physique avec des propriétés liées à ses dimensions et son poids.
 */
class ProduitPhysique extends Produit
{
    private float $poids;
    private float $longueur;
    private float $largeur;
    private float $hauteur;

    public function __construct(string $nom, string $description, float $prix, int $stock, float $poids, float $longueur, float $largeur, float $hauteur)
    {
        parent::__construct($nom, $description, $prix, $stock);
        $this->poids = $poids;
        $this->longueur = $longueur;
        $this->largeur = $largeur;
        $this->hauteur = $hauteur;
    }

    public function calculerVolume(): float
    {
        return $this->longueur * $this->largeur * $this->hauteur;
    }

    public function calculerFraisLivraison(): float
    {
        return $this->poids * 1.5; // Exemple : 1,5 $ par kg
    }

    public function afficherDetails(): void
    {
        echo "Produit physique : {$this->getNom()}, Poids : {$this->poids}kg, Volume : {$this->calculerVolume()} cm³.\n";
    }
}
