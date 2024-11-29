<?php

namespace App\Service;

use App\Repository\PanierRepository;
use App\Service\ProduitService;
use App\Entity\Produit\Produit;
use App\Repository\CommandeRepository;


class PanierService
{
    private PanierRepository $panierRepository;
    private CommandeRepository $commandeRepository;

    private ProduitService $produitService;

    public function __construct()
    {
        $this->panierRepository = new PanierRepository();
        $this->produitService = new ProduitService();
        $this->commandeRepository = new CommandeRepository();

    }

    public function recupererOuCreerPanierPourUtilisateur(int $utilisateurId): int
    {
        $panierId = $this->panierRepository->recupererPanierIdParUtilisateur($utilisateurId);
        if (!$panierId) {
            $panierId = $this->panierRepository->creerPanier($utilisateurId);
        }
        return $panierId;
    }

    public function ajouterArticle(int $panierId, int $produitId, int $quantite): void
    {
        // Vérifier si le produit existe et a assez de stock
        $produit = $this->produitService->recupererProduitParId($produitId);

        if (!$produit) {
            throw new \Exception("Produit introuvable.");
        }

        if (!$produit->verifierStock($quantite)) {
            throw new \Exception("Quantité demandée supérieure au stock disponible.");
        }

        // Ajouter le produit au panier
        $this->panierRepository->ajouterArticleAuPanier($panierId, $produitId, $quantite);

        // Mettre à jour le stock du produit
        $nouveauStock = $produit->getStock() - $quantite;
        $produit->setStock($nouveauStock);
        $this->produitService->mettreAJourProduit($produit);
    }

    public function retirerArticle(int $panierId, int $produitId, int $quantite): void
    {
        // Vérifier si le produit existe dans le panier
        $articles = $this->panierRepository->recupererArticlesDuPanier($panierId);
        $articleExiste = false;

        foreach ($articles as $article) {
            if ($article['produit_id'] === $produitId) {
                $articleExiste = true;
                break;
            }
        }

        if (!$articleExiste) {
            throw new \Exception("Produit introuvable dans le panier.");
        }

        // Mettre à jour ou retirer complètement l'article
        foreach ($articles as $article) {
            if ($article['produit_id'] === $produitId) {
                if ($article['quantite'] > $quantite) {
                    $nouvelleQuantite = $article['quantite'] - $quantite;
                    $this->panierRepository->mettreAJourQuantite($panierId, $produitId, $nouvelleQuantite);
                } else {
                    $this->panierRepository->supprimerArticleDuPanier($panierId, $produitId);
                }
                break;
            }
        }

        // Rendre le stock au produit
        $produit = $this->produitService->recupererProduitParId($produitId);
        $nouveauStock = $produit->getStock() + $quantite;
        $produit->setStock($nouveauStock);
        $this->produitService->mettreAJourProduit($produit);
    }

    public function viderPanier(int $panierId): void
    {
        $articles = $this->panierRepository->recupererArticlesDuPanier($panierId);

        // Rendre le stock pour tous les produits du panier
        foreach ($articles as $article) {
            $produit = $this->produitService->recupererProduitParId($article['produit_id']);
            if ($produit) {
                $nouveauStock = $produit->getStock() + $article['quantite'];
                $produit->setStock($nouveauStock);
                $this->produitService->mettreAJourProduit($produit);
            }
        }

        // Vider le panier
        $this->panierRepository->viderPanier($panierId);
    }

    public function compterArticles(int $panierId): int
    {
        // Récupérer directement les données brutes du panier
        $articles = $this->panierRepository->recupererArticlesDuPanier($panierId);
    
        // Compter le total des quantités
        $total = 0;
        foreach ($articles as $article) {
            $total += $article['quantite'];
        }
    
        return $total;
    }
    


    public function recupererArticles(int $panierId): array
{
    $articles = $this->panierRepository->recupererArticlesDuPanier($panierId);

    // Convertir les données brutes en objets
    $resultat = [];
    foreach ($articles as $article) {
        $produit = $this->produitService->recupererProduitParId($article['produit_id']);
        if ($produit) {
            $resultat[] = [
                'produit' => $produit,
                'quantite' => $article['quantite'],
            ];
        }
    }

    return $resultat;
}


    public function calculerTotal(array $articles): float
    {
        $total = 0;
        foreach ($articles as $article) {
            /** @var Produit $produit */
            $produit = $article['produit'];
            $total += $produit->getPrix() * $article['quantite'];
        }
        return $total;
    }

    public function passerCommande(int $utilisateurId, int $panierId): void
    {
        // Récupérer les articles du panier
        $articles = $this->recupererArticles($panierId);

        if (empty($articles)) {
            throw new \Exception("Le panier est vide.");
        }

        // Calculer le total
        $total = $this->calculerTotal($articles);

        // Créer une commande
        $commandeId = $this->commandeRepository->creerCommande($utilisateurId, $total);

        // Ajouter les articles à la commande
        $this->commandeRepository->ajouterArticlesCommande($commandeId, $articles);

        // Vider le panier
        $this->panierRepository->viderPanier($panierId);
    }
}
