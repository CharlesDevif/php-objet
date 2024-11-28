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
        if ($produit->getPrix() <= 0) {
            throw new \InvalidArgumentException('Le prix doit être supérieur à 0.');
        }

        if (strlen($produit->getNom()) <= 1) {
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
        if ($produit->getStock() < 0) {
            throw new \InvalidArgumentException('Le stock ne peut pas être négatif.');
        }

        $this->produitRepository->update($produit);
    }

    public function supprimerProduit(int $id): void
    {
        $this->produitRepository->delete($id);
    }

    /**
     * Récupérer des produits pour affichage (e.g., en promotion ou les plus populaires).
     */
    public function recupererProduitsAffichables(int $limite = 10): array
    {
        $produits = $this->produitRepository->findAll();
        return array_slice($produits, 0, $limite);
    }

    /**
     * Vérifie et met à jour le stock d'un produit après ajout au panier.
     */
    public function verifierEtMettreAJourStock(int $idProduit, int $quantite): bool
    {
        $produit = $this->produitRepository->read($idProduit);

        if ($produit && $produit->getStock() >= $quantite) {
            $produit->setStock($produit->getStock() - $quantite);
            $this->produitRepository->update($produit);
            return true;
        }

        return false;
    }
}
