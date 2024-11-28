<?php

namespace App\Service;

use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur\Utilisateur;

class UtilisateurService
{
    private UtilisateurRepository $utilisateurRepository;

    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    public function creerUtilisateur(Utilisateur $utilisateur): int
    {
        // Vérification de logique métier
        if (!filter_var($utilisateur->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('L\'adresse email est invalide.');
        }

        return $this->utilisateurRepository->create($utilisateur);
    }

    public function recupererUtilisateurParId(int $id): ?Utilisateur
    {
        return $this->utilisateurRepository->read($id);
    }

    public function mettreAJourUtilisateur(Utilisateur $utilisateur): void
    {
        $this->utilisateurRepository->update($utilisateur);
    }

    public function supprimerUtilisateur(int $id): void
    {
        $this->utilisateurRepository->delete($id);
    }
}
