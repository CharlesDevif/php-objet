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

    public function __construct(string $nom, string $email, string $motDePasse, ?string $adresseLivraison = '')
    {
        parent::__construct($nom, $email, $motDePasse);
        $this->adresseLivraison = $adresseLivraison ?? '';
        $this->panier = new Panier();
        $this->ajouterRole('ROLE_CLIENT'); // Ajoute le rôle spécifique
    }

    // Gestion de l'adresse de livraison
    public function getAdresseLivraison(): string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(string $adresse): void
    {
        $this->adresseLivraison = $adresse;
    }

    // Gestion du panier
    public function getPanier(): Panier
    {
        return $this->panier;
    }

    // Méthodes utilisateur spécifiques
    public function passerCommande(): void
    {
        // À implémenter plus tard
    }

    public function consulterHistorique(): array
    {
        // À implémenter plus tard
        return [];
    }

    // Affichage des rôles (hérité d'Utilisateur)
    public function afficherRoles(): void
    {
        echo "Rôles du client {$this->nom} : " . implode(', ', $this->getRoles()) . "\n";
    }

    // Méthode pour définir un mot de passe haché (utile pour le Repository)
    public function setMotDePasseHache(string $motDePasseHache): void
    {
        $this->motDePasse = $motDePasseHache;
    }
}
