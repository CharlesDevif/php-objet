<?php

namespace App\Entity\Utilisateur;

use App\Entity\Panier;

/**
 * Classe représentant un client.
 */
class Client extends Utilisateur
{
    private string $adresseLivraison;
    private Panier $panier;

    public function __construct(string $nom, string $email, string $motDePasse, string $adresseLivraison)
    {
        parent::__construct($nom, $email, $motDePasse);
        $this->adresseLivraison = $adresseLivraison;
        $this->panier = new Panier();
        $this->roles[] = 'ROLE_CLIENT';
    }

    public function getAdresseLivraison(): string { return $this->adresseLivraison; }
    public function setAdresseLivraison(string $adresse): void { $this->adresseLivraison = $adresse; }

    public function getPanier(): Panier { return $this->panier; }

    public function passerCommande(): void
    {
        // À implémenter plus tard
    }

    public function consulterHistorique(): array
    {
        // À implémenter plus tard
        return [];
    }

    public function afficherRoles(): void
    {
        echo "Roles du client {$this->nom} : " . implode(', ', $this->roles) . "\n";
    }
}

