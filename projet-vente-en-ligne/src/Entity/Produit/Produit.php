<?php

namespace App\Entity\Produit;
use App\Config\ConfigurationManager;
/**
 * Classe abstraite représentant un produit.
 */
abstract class Produit
{
    private ?int $id;
    private string $nom;
    private string $description;
    private float $prix;
    private int $stock;

    public function __construct(string $nom, string $description, float $prix, int $stock)
    {
        $this->setNom($nom);
        $this->setDescription($description);
        $this->setPrix($prix);
        $this->setStock($stock);
        $this->id = null;
    }

    // Getters et setters pour les propriétés communes

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    public function getPrix(): float { return $this->prix; }
    public function setPrix(float $prix): void { $this->prix = $prix; }

    public function getStock(): int { return $this->stock; }
    public function setStock(int $stock): void { $this->stock = $stock; }

    public function getId(): ?int { return $this->id; }

    public function calculerPrixTTC(): float
{
    $configManager = ConfigurationManager::getInstance();
    $tva = $configManager->get('tva');
    return $this->prix * (1 + $tva / 100);
}


    // Méthode abstraite pour les frais de livraison
    abstract public function calculerFraisLivraison(): float;

    // Méthode abstraite pour afficher les détails du produit
    abstract public function afficherDetails(): void;
}
