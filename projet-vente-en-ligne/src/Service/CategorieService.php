<?php

namespace App\Service;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;

class CategorieService
{
    private CategorieRepository $categorieRepository;

    public function __construct()
    {
        $this->categorieRepository = new CategorieRepository();
    }

    public function creerCategorie(Categorie $categorie): int
    {
        if (strlen($categorie->getNom()) < 2) {
            throw new \InvalidArgumentException('Le nom de la catégorie doit comporter au moins 2 caractères.');
        }

        return $this->categorieRepository->create($categorie);
    }

    public function recupererToutesLesCategories(): array
    {
        return $this->categorieRepository->findAll();
    }

    public function recupererCategorieParId(int $id): ?Categorie
    {
        return $this->categorieRepository->read($id);
    }

    public function mettreAJourCategorie(Categorie $categorie): void
    {
        $this->categorieRepository->update($categorie);
    }

    public function associerProduitCategorie(int $produitId, int $categorieId): void
    {
        $this->categorieRepository->ajouterProduitCategorie($produitId, $categorieId);
    }

    public function recupererProduitsParCategorie(int $categorieId): array
    {
        return $this->categorieRepository->recupererProduitsParCategorie($categorieId);
    }

    public function supprimerProduitDeCategorie(int $produitId, int $categorieId): void
    {
        $this->categorieRepository->supprimerProduitCategorie($produitId, $categorieId);
    }

    public function supprimerCategorie(int $id): void
    {
        $this->categorieRepository->delete($id);
    }
}
