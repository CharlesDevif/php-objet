<?php

namespace App\Entity;

/**
 * Classe représentant un produit.
 */
class Produit
{
    /**
     * @var int|null Identifiant du produit.
     */
    private ?int $id;

    /**
     * @var string Nom du produit.
     */
    private string $nom;

    /**
     * @var string Description du produit.
     */
    private string $description;

    /**
     * @var float Prix du produit.
     */
    private float $prix;

    /**
     * @var int Stock disponible.
     */
    private int $stock;

    /**
     * Constructeur de la classe Produit.
     *
     * @param string $nom
     * @param string $description
     * @param float $prix
     * @param int $stock
     */
    public function __construct(string $nom, string $description, float $prix, int $stock)
    {
        $this->setNom($nom);
        $this->setDescription($description);
        $this->setPrix($prix);
        $this->setStock($stock);
        $this->id = null;
    }

    // Getters et setters avec validation

    /**
     * Obtient le nom du produit.
     *
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Définit le nom du produit.
     *
     * @param string $nom
     * @return void
     */
    public function setNom(string $nom): void
    {
        if (empty($nom)) {
            throw new \InvalidArgumentException("Le nom ne peut pas être vide.");
        }
        $this->nom = $nom;
    }


    /**
     * Calcule le prix TTC en appliquant une TVA de 20 %.
     *
     * @return float
     */
    public function calculerPrixTTC(): float
    {
        return $this->prix * 1.20;
    }

    /**
     * Vérifie si le stock est suffisant pour la quantité demandée.
     *
     * @param int $quantite
     * @return bool
     */
    public function verifierStock(int $quantite): bool
    {
        return $this->stock >= $quantite;
    }


    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        if (empty($description)) {
            throw new \InvalidArgumentException("La description ne peut pas être vide.");
        }
        $this->description = $description;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): void
    {
        if ($prix <= 0) {
            throw new \InvalidArgumentException("Le prix doit être positif.");
        }
        $this->prix = $prix;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        if ($stock < 0) {
            throw new \InvalidArgumentException("Le stock ne peut pas être négatif.");
        }
        $this->stock = $stock;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
