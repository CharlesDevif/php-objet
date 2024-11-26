<?php

namespace App\Entity\Utilisateur;

abstract class Utilisateur
{
    protected ?int $id;
    protected string $nom;
    protected string $email;
    protected string $motDePasse; // Stockera le mot de passe haché
    protected \DateTime $dateInscription;
    protected array $roles = [];

    public function __construct(string $nom, string $email, string $motDePasse)
    {
        $this->setNom($nom);
        $this->setEmail($email);
        $this->setMotDePasse($motDePasse);
        $this->dateInscription = new \DateTime();
    }

    // Getters et setters

    public function getId(): ?int
    {
        return $this->id;
    }

    // Note: setId() method should be public if you need to set the ID from the repository
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        if (empty($nom)) {
            throw new \InvalidArgumentException("Le nom ne doit pas être vide.");
        }
        $this->nom = $nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Adresse email invalide.");
        }
        $this->email = $email;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): void
    {
        if (strlen($motDePasse) < 8) {
            throw new \InvalidArgumentException("Le mot de passe doit contenir au moins 8 caractères.");
        }
        // Hachage du mot de passe
        $this->motDePasse = password_hash($motDePasse, PASSWORD_DEFAULT);
    }

    public function getDateInscription(): \DateTime
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTime $dateInscription): void
    {
        $this->dateInscription = $dateInscription;
    }

    // Méthodes

    public function verifierMotDePasse(string $motDePasse): bool
    {
        return password_verify($motDePasse, $this->motDePasse);
    }

    public function mettreAJourProfil(string $nom, string $email, string $motDePasse): void
    {
        $this->setNom($nom);
        $this->setEmail($email);
        if (!empty($motDePasse)) {
            $this->setMotDePasse($motDePasse);
        }
    }

    abstract public function afficherRoles(): void;
}
