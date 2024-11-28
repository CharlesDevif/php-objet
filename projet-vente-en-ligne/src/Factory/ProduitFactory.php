<?php

namespace App\Factory;

use App\Entity\Produit\ProduitPhysique;
use App\Entity\Produit\ProduitNumerique;
use App\Entity\Produit\ProduitPerissable;
use App\Entity\Produit\Produit;

class ProduitFactory
{
    /**
     * Crée un produit en fonction du type spécifié et des données fournies.
     *
     * @param string $type Le type de produit ("physique", "numerique", "perissable").
     * @param array $data Les données nécessaires à la création du produit.
     * @return Produit
     * @throws \InvalidArgumentException Si le type est invalide ou les données manquantes.
     */
    public static function creerProduit(string $type, array $data): Produit
    {
        switch (strtolower($type)) {
            case 'physique':
                return self::creerProduitPhysique($data);
            case 'numerique':
                return self::creerProduitNumerique($data);
            case 'perissable':
                return self::creerProduitPerissable($data);
            default:
                throw new \InvalidArgumentException("Type de produit invalide : $type");
        }
    }

    private static function creerProduitPhysique(array $data): ProduitPhysique
    {
        // Validation des données
        $requiredFields = ['nom', 'description', 'prix', 'stock', 'poids', 'longueur', 'largeur', 'hauteur'];
        self::validerDonnees($data, $requiredFields);

        $produit = new ProduitPhysique(
            $data['nom'],
            $data['description'],
            $data['prix'],
            $data['stock'],
            $data['poids'],
            $data['longueur'],
            $data['largeur'],
            $data['hauteur']
        );
        if (isset($data['id'])) {
            $produit->setId($data['id']);
        }

        return  $produit;
    }

    private static function creerProduitNumerique(array $data): ProduitNumerique
    {
        // Validation des données
        $requiredFields = ['nom', 'description', 'prix', 'stock', 'lienTelechargement', 'tailleFichier', 'formatFichier'];
        self::validerDonnees($data, $requiredFields);

        $produit = new ProduitNumerique(
            $data['nom'],
            $data['description'],
            $data['prix'],
            $data['stock'],
            $data['lienTelechargement'],
            $data['tailleFichier'],
            $data['formatFichier']
        );

        if (isset($data['id'])) {
            $produit->setId($data['id']);
        }

        return  $produit;
    }

    private static function creerProduitPerissable(array $data): ProduitPerissable
    {
        // Validation des données
        $requiredFields = ['nom', 'description', 'prix', 'stock', 'dateExpiration', 'temperatureStockage'];
        self::validerDonnees($data, $requiredFields);

        // Convertir dateExpiration en objet DateTime si nécessaire
        if (!$data['dateExpiration'] instanceof \DateTime) {
            $data['dateExpiration'] = new \DateTime($data['dateExpiration']);
        }

        $produit = new ProduitPerissable(
            $data['nom'],
            $data['description'],
            $data['prix'],
            $data['stock'],
            $data['dateExpiration'],
            $data['temperatureStockage']
        );

        
        if (isset($data['id'])) {
            $produit->setId($data['id']);
        }

        return  $produit;
    }

    private static function validerDonnees(array $data, array $requiredFields): void
    {
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new \InvalidArgumentException("Le champ '$field' est requis.");
            }
        }
    }
}
