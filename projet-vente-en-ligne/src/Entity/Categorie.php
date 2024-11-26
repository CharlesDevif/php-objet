<?php

namespace App\Entity;

use App\Entity\Produit\Produit;

class Categorie
{
    private int $id;
    private string $nom;
    private string $description;
    private array $produits = [];

    public function __construct(int $id, string $nom, string $description)
    {
        $this->id = $id;
        $this->nom = $nom;
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
