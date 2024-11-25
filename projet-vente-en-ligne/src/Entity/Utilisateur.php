<?php

namespace App\Entity;

/**
 * Classe représentant un utilisateur.
 */
class Utilisateur
{
    /**
     * @var int|null Identifiant de l'utilisateur.
     */
    private ?int $id;

    /**
     * @var string Nom de l'utilisateur.
     */
    private string $nom;

    /**
     * @var string Email de l'utilisateur.
     */
    private string $email;

    /**
     * @var string Mot de passe de l'utilisateur.
     */
    private string $motDePasse;

    /**
     * @var \DateTime Date d'inscription de l'utilisateur.
     */
    private \DateTime $dateInscription;

    /**
     * Constructeur de la classe Utilisateur.
     *
     * @param string $nom
     * @param string $email
     * @param string $motDePasse
     */
    public function __construct(string $nom, string $email, string $motDePasse)
    {
        $this->setNom($nom);
        $this->setEmail($email);
        $this->setMotDePasse($motDePasse);
        $this->dateInscription = new \DateTime();
        $this->id = null;
    }

    // Getters et setters avec validation

    /**
     * Vérifie si le mot de passe fourni correspond à celui de l'utilisateur.
     *
     * @param string $motDePasse
     * @return bool
     */
    public function verifierMotDePasse(string $motDePasse): bool
    {
        return $this->motDePasse === $motDePasse;
    }

    /**
     * Met à jour les informations de l'utilisateur avec validation appropriée.
     *
     * @param string $nom
     * @param string $email
     * @param string $motDePasse
     * @return void
     */
    public function mettreAJourProfil(string $nom, string $email, string $motDePasse): void
    {
        $this->setNom($nom);
        $this->setEmail($email);
        $this->setMotDePasse($motDePasse);
    }

    // Getters et setters restants...

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        if (empty($nom)) {
            throw new \InvalidArgumentException("Le nom ne peut pas être vide.");
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
            throw new \InvalidArgumentException("L'email n'est pas valide.");
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
        $this->motDePasse = $motDePasse;
    }

    public function getDateInscription(): \DateTime
    {
        return $this->dateInscription;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
