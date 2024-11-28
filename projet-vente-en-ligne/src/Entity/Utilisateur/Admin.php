<?php

namespace App\Entity\Utilisateur;

/**
 * Classe représentant un administrateur.
 */
class Admin extends Utilisateur
{
    private int $niveauAcces;
    private \DateTime $derniereConnexion;

    public function __construct(string $nom, string $email, string $motDePasse, int $niveauAcces)
    {
        parent::__construct($nom, $email, $motDePasse);
        $this->niveauAcces = $niveauAcces;
        $this->derniereConnexion = new \DateTime();
        $this->roles[] = 'ROLE_ADMIN';
    }

    public function getNiveauAcces(): int { return $this->niveauAcces; }
    public function setNiveauAcces(int $niveau): void { $this->niveauAcces = $niveau; }

    public function getDerniereConnexion(): \DateTime { return $this->derniereConnexion; }
    public function setDerniereConnexion(\DateTime $date): void { $this->derniereConnexion = $date; }

    public function gererUtilisateurs(): void
    {
        // À implémenter plus tard
    }

    public function accederJournalSysteme(): array
    {
        // À implémenter plus tard
        return [];
    }

    public function afficherRoles(): void
    {
        echo "Roles de l'administrateur {$this->nom} : " . implode(', ', $this->getRoles()) . "\n";
    }
    public function setMotDePasseHache(string $motDePasseHache): void
    {
        $this->motDePasse = $motDePasseHache;
    }
}

