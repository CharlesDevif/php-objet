<?php

namespace App\Entity;

use App\Entity\Produit\Produit;

class Panier
{
    private array $articles = [];
    private \DateTime $dateCreation;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }

    public function ajouterArticle(Produit $produit, int $quantite): void
    {
        $id = $produit->getId(); // Utilisation de l'ID réel du produit
        if (isset($this->articles[$id])) {
            $this->articles[$id]['quantite'] += $quantite;
        } else {
            $this->articles[$id] = ['produit' => $produit, 'quantite' => $quantite];
        }
    }

    public function retirerArticle(Produit $produit, int $quantite): void
    {
        $id = $produit->getId(); // Utilisation de l'ID réel du produit
        if (isset($this->articles[$id])) {
            $this->articles[$id]['quantite'] -= $quantite;
            if ($this->articles[$id]['quantite'] <= 0) {
                unset($this->articles[$id]);
            }
        }
    }

    public function vider(): void
    {
        $this->articles = [];
    }

    public function calculerTotal(): float
    {
        $total = 0;
        foreach ($this->articles as $article) {
            $total += $article['produit']->getPrix() * $article['quantite'];
        }
        return $total;
    }

    public function compterArticles(): int
    {
        $total = 0;
        foreach ($this->articles as $article) {
            $total += $article['quantite'];
        }
        return $total;
    }
    

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function getDateCreation(): \DateTime
    {
        return $this->dateCreation;
    }

    
}

