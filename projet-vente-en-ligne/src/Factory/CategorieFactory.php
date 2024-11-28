<?php

namespace App\Factory;

use App\Entity\Categorie;

class CategorieFactory
{
    public static function creerCategorie(array $donnees): Categorie
    {
        if (!isset($donnees['nom']) || !isset($donnees['description'])) {
            throw new \InvalidArgumentException("Les données sont incomplètes pour créer une catégorie.");
        }

        return new Categorie($donnees['nom'], $donnees['description']);
    }
}
