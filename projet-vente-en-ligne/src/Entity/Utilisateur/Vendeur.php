<?php

namespace App\Entity\Utilisateur;

use App\Entity\Produit\Produit;

/**
 * Classe représentant un vendeur.
 */
class Vendeur extends Utilisateur
{
    private string $boutique;
    private float $commission;

    public function __construct(string $nom, string $email, string $motDePasse, string $boutique, float $commission)
    {
        parent::__construct($nom, $email, $motDePasse);
        $this->boutique = $boutique;
        $this->commission = $commission;
        $this->roles[] = 'ROLE_VENDEUR';
    }

    public function getBoutique(): string { return $this->boutique; }
    public function setBoutique(string $boutique): void { $this->boutique = $boutique; }

    public function getCommission(): float { return $this->commission; }
    public function setCommission(float $commission): void { $this->commission = $commission; }

    public function ajouterProduit(Produit $produit): void
    {
        // À implémenter plus tard
    }

    public function gererStock(Produit $produit, int $quantite): void
    {
        // À implémenter plus tard
    }

    public function afficherRoles(): void
    {
        echo "Roles du vendeur {$this->nom} : " . implode(', ', $this->getRoles()) . "\n";
    }
    public function setMotDePasseHache(string $motDePasseHache): void
    {
        $this->motDePasse = $motDePasseHache;
    }
}

