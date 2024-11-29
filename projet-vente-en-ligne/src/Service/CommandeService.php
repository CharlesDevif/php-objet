<?php

namespace App\Service;

use App\Repository\CommandeRepository;

class CommandeService
{
    private CommandeRepository $commandeRepository;

    public function __construct()
    {
        $this->commandeRepository = new CommandeRepository();
    }

    /**
     * Créer une nouvelle commande et ajouter les articles.
     *
     * @param int $utilisateurId
     * @param array $articles
     * @param float $total
     * @return int
     */
    public function creerCommande(int $utilisateurId, array $articles, float $total): int
    {
        // Créer la commande
        $commandeId = $this->commandeRepository->creerCommande($utilisateurId, $total);

        // Ajouter les articles à la commande
        $this->commandeRepository->ajouterArticlesCommande($commandeId, $articles);

        return $commandeId;
    }

    /**
     * Récupérer l'historique des commandes d'un utilisateur.
     *
     * @param int $utilisateurId
     * @return array
     */
    public function recupererCommandesUtilisateur(int $utilisateurId): array
    {
        return $this->commandeRepository->recupererCommandesUtilisateur($utilisateurId);
    }

    /**
     * Récupérer les détails d'une commande pour un utilisateur.
     *
     * @param int $commandeId
     * @param int $utilisateurId
     * @return array|null
     */
    public function recupererCommandeParId(int $commandeId, int $utilisateurId): ?array
    {
        return $this->commandeRepository->recupererCommandeParId($commandeId, $utilisateurId);
    }
}
