<?php

namespace App\Service;

use App\Repository\ProduitRepository;
use App\Entity\Produit\Produit;

class ProduitService
{
    private ProduitRepository $produitRepository;

    public function __construct()
    {
        $this->produitRepository = new ProduitRepository();
    }

    public function creerProduit(Produit $produit): int
    {
        // Exemple de validation métier avant d'appeler le repository
        if ($produit->getPrix() <= 0) {
            throw new \InvalidArgumentException('Le prix doit être supérieur à 0.');
        } else if (strlen($produit->getNom()) <= 1) {
            throw new \InvalidArgumentException("Le nom doit comporter plus d'un caractère.");
        }

        return $this->produitRepository->create($produit);
    }

    public function recupererTousLesProduits(): array
    {
        return $this->produitRepository->findAll();
    }

    public function recupererProduitParId(int $id): ?Produit
    {
        return $this->produitRepository->read($id);
    }

    public function mettreAJourProduit(Produit $produit): void
    {
        // Validation métier, par exemple : vérifier que le stock est positif
        if ($produit->getStock() < 0) {
            throw new \InvalidArgumentException('Le stock ne peut pas être négatif.');
        }

        $this->produitRepository->update($produit);
    }

    public function supprimerProduit(int $id): void
    {
        $this->produitRepository->delete($id);
    }
}
