<?php

namespace App\Entity\Produit;

/**
 * Produit numérique téléchargeable.
 */
class ProduitNumerique extends Produit
{
    private string $lienTelechargement;
    private float $tailleFichier;
    private string $formatFichier;

    public function __construct(
        string $nom,
        string $description,
        float $prix,
        int $stock,
        string $lienTelechargement,
        float $tailleFichier,
        string $formatFichier
    ) {
        parent::__construct($nom, $description, $prix, $stock);
        $this->lienTelechargement = $lienTelechargement;
        $this->tailleFichier = $tailleFichier;
        $this->formatFichier = $formatFichier;
    }

    // Getters et setters
    public function getLienTelechargement(): string
    {
        return $this->lienTelechargement;
    }

    public function setLienTelechargement(string $lienTelechargement): void
    {
        $this->lienTelechargement = $lienTelechargement;
    }

    public function getTailleFichier(): float
    {
        return $this->tailleFichier;
    }

    public function setTailleFichier(float $tailleFichier): void
    {
        $this->tailleFichier = $tailleFichier;
    }

    public function getFormatFichier(): string
    {
        return $this->formatFichier;
    }

    public function setFormatFichier(string $formatFichier): void
    {
        $this->formatFichier = $formatFichier;
    }

    public function genererLienTelechargement(): string
    {
        return $this->lienTelechargement . "?token=" . uniqid();
    }

    public function calculerFraisLivraison(): float
    {
        return 0;
    }

    public function afficherDetails(): void
    {
        echo "Produit numérique : {$this->getNom()}, Taille : {$this->tailleFichier}MB, Format : {$this->formatFichier}.\n";
    }
}
