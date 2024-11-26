<?php

namespace App\Entity\Utilisateur;

/**
 * Classe abstraite représentant un utilisateur.
 */
abstract class Utilisateur
{
    protected ?int $id;
    protected string $nom;
    protected string $email;
    protected string $motDePasse;
    protected \DateTime $dateInscription;
    protected array $roles = [];

    public function __construct(string $nom, string $email, string $motDePasse)
    {
        $this->setNom($nom);
        $this->setEmail($email);
        $this->setMotDePasse($motDePasse);
        $this->dateInscription = new \DateTime();
        $this->id = null;
    }

    // Getters et setters

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void
    {
        if (empty($nom)) {
            throw new \InvalidArgumentException("Le nom ne peut pas être vide.");
        }
        $this->nom = $nom;
    }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("L'email n'est pas valide.");
        }
        $this->email = $email;
    }

    public function getMotDePasse(): string { return $this->motDePasse; }
    public function setMotDePasse(string $motDePasse): void
    {
        if (strlen($motDePasse) < 8) {
            throw new \InvalidArgumentException("Le mot de passe doit contenir au moins 8 caractères.");
        }
        $this->motDePasse = $motDePasse;
    }

    public function getDateInscription(): \DateTime { return $this->dateInscription; }
    public function getId(): ?int { return $this->id; }

    public function getRoles(): array { return $this->roles; }

    // Méthode abstraite
    abstract public function afficherRoles(): void;

    // Méthode pour vérifier le mot de passe
    public function verifierMotDePasse(string $motDePasse): bool
    {
        return $this->motDePasse === $motDePasse;
    }
}

