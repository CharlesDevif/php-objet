<?php

namespace App\Entity;

use App\Entity\Produit\Produit;

class Categorie
{
    private ?int $id;
    private string $nom;
    private string $description;
    private array $produits = [];

    public function __construct(string $nom, string $description, ?int $id = null)
    {
        $this->nom = $nom;
        $this->description = $description;
        $this->id = $id;
    }

    // Getters et setters pour l'ID
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function ajouterProduit(Produit $produit): void
    {
        $this->produits[] = $produit;
    }

    public function retirerProduit(Produit $produit): void
    {
        $this->produits = array_filter($this->produits, fn($p) => $p !== $produit);
    }

    public function listerProduits(): array
    {
        return $this->produits;
    }
}
