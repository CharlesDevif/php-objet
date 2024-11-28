<?php

namespace App\Service;

use App\Entity\Utilisateur\Client;
use App\Entity\Utilisateur\Utilisateur;
use App\Entity\Utilisateur\Vendeur;
use App\Repository\UtilisateurRepository;

class UtilisateurService
{
    private UtilisateurRepository $utilisateurRepository;

    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    public function creerUtilisateur(Utilisateur $utilisateur): int
    {
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

    public function connexion(string $email, string $motDePasse): ?Utilisateur
    {
        // Recherche de l'utilisateur par email
        $utilisateurs = $this->utilisateurRepository->findBy(['email' => $email]);
    
        if (count($utilisateurs) === 1) {
            $utilisateur = $utilisateurs[0];
    
            // Vérifie si le mot de passe est correct
            if ($utilisateur->verifierMotDePasse($motDePasse)) {
                return $utilisateur;
            }
        }
    
        return null;
    }

    public function inscription(array $donnees, string $type): int
    {
        // Validation des données
        if (!filter_var($donnees['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Adresse email invalide.');
        }

        if (strlen($donnees['mot_de_passe']) < 6) {
            throw new \InvalidArgumentException('Le mot de passe doit contenir au moins 6 caractères.');
        }

        // Vérifie si l'utilisateur existe déjà
        $utilisateurs = $this->utilisateurRepository->findBy(['email' => $donnees['email']]);
        if (!empty($utilisateurs)) {
            throw new \InvalidArgumentException('Un utilisateur avec cet email existe déjà.');
        }

        // Crée l'utilisateur en fonction du type
        if ($type === 'client') {
            $utilisateur = new Client(
                $donnees['nom'],
                $donnees['email'],
                $donnees['mot_de_passe'], // Le mot de passe sera haché par `setMotDePasse`
                $donnees['adresse_livraison'] ?? ''
            );
        } elseif ($type === 'vendeur') {
            $utilisateur = new Vendeur(
                $donnees['nom'],
                $donnees['email'],
                $donnees['mot_de_passe'], // Le mot de passe sera haché par `setMotDePasse`
                $donnees['boutique'] ?? '',
                (float)($donnees['commission'] ?? 0.0)
            );
        } else {
            throw new \InvalidArgumentException('Type d\'utilisateur non valide.');
        }

        // Hacher le mot de passe avant la création
        $utilisateur->setMotDePasse($donnees['mot_de_passe']);

        return $this->utilisateurRepository->create($utilisateur);
    }

    public function verifierRole(Utilisateur $utilisateur, string $role): bool
    {
        return in_array($role, $utilisateur->getRoles());
    }
}
