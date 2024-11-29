<?php

namespace App\Controllers;

use App\Service\PanierService;
use App\Service\ProduitService;

class PanierController extends Controller
{
    private PanierService $panierService;
    private ProduitService $produitService;

    public function __construct()
    {
        $this->panierService = new PanierService();
        $this->produitService = new ProduitService();
    }

    private function verifierUtilisateur(): void
    {
        if (!isset($_SESSION['utilisateur'])) {
            $_SESSION['erreur_panier'] = 'Vous devez être connecté pour accéder au panier.';
            header('Location: /projet-vente-en-ligne/utilisateur/connexion');
            exit();
        }
    }
    

    public function ajouter()
    {
        $this->verifierUtilisateur();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit'], $_POST['quantite'])) {
            $idProduit = (int)$_POST['id_produit'];
            $quantite = max((int)$_POST['quantite'], 1);

            try {
                $produit = $this->produitService->recupererProduitParId($idProduit);

                if (!$produit || !$produit->verifierStock($quantite)) {
                    throw new \Exception('Stock insuffisant ou produit introuvable.');
                }

                $utilisateur = unserialize($_SESSION['utilisateur']);
                $panierId = $this->panierService->recupererOuCreerPanierPourUtilisateur($utilisateur->getId());

                $this->panierService->ajouterArticle($panierId, $idProduit, $quantite);

                $_SESSION['success_message'] = 'Produit ajouté au panier avec succès.';
            } catch (\Exception $e) {
                $_SESSION['erreur_panier'] = $e->getMessage();
            }
        }

        header('Location: /projet-vente-en-ligne/panier');
        exit();
    }

    public function index()
    {
        $this->verifierUtilisateur();
    
        try {
            $utilisateur = unserialize($_SESSION['utilisateur']);
            $panierId = $this->panierService->recupererOuCreerPanierPourUtilisateur($utilisateur->getId());
            $articles = $this->panierService->recupererArticles($panierId);
    
            $this->render('panier/index', [
                'articles' => $articles,
                'total' => $this->panierService->calculerTotal($articles),
            ], 'default');
        } catch (\Exception $e) {
            $_SESSION['erreur_panier'] = $e->getMessage();
            header('Location: /projet-vente-en-ligne/');
            exit();
        }
    }
    
    

    public function retirer()
    {
        $this->verifierUtilisateur();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit'], $_POST['quantite'])) {
            $idProduit = (int)$_POST['id_produit'];
            $quantite = max((int)$_POST['quantite'], 1);

            try {
                $utilisateur = unserialize($_SESSION['utilisateur']);
                $panierId = $this->panierService->recupererOuCreerPanierPourUtilisateur($utilisateur->getId());

                $this->panierService->retirerArticle($panierId, $idProduit, $quantite);

                $_SESSION['success_message'] = 'Produit retiré du panier avec succès.';
            } catch (\Exception $e) {
                $_SESSION['erreur_panier'] = $e->getMessage();
            }
        }

        header('Location: /projet-vente-en-ligne/panier');
        exit();
    }

    public function vider()
    {
        $this->verifierUtilisateur();

        try {
            $utilisateur = unserialize($_SESSION['utilisateur']);
            $panierId = $this->panierService->recupererOuCreerPanierPourUtilisateur($utilisateur->getId());

            $this->panierService->viderPanier($panierId);

            $_SESSION['success_message'] = 'Panier vidé avec succès.';
        } catch (\Exception $e) {
            $_SESSION['erreur_panier'] = $e->getMessage();
        }

        header('Location: /projet-vente-en-ligne/panier');
        exit();
    }

    public function confirmationCommande()
    {
        $this->verifierUtilisateur();
    
        try {
            $utilisateur = unserialize($_SESSION['utilisateur']);
            $panierId = $this->panierService->recupererOuCreerPanierPourUtilisateur($utilisateur->getId());
            $articles = $this->panierService->recupererArticles($panierId);
            $total = $this->panierService->calculerTotal($articles);
    
            // Rendre la vue de confirmation
            $this->render('panier/confirmation', [
                'articles' => $articles,
                'total' => $total,
            ], 'default');
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: /projet-vente-en-ligne/panier');
            exit();
        }
    }
    

    public function validerCommande()
    {
        $this->verifierUtilisateur();
    
        try {
            $utilisateur = unserialize($_SESSION['utilisateur']);
            $panierId = $this->panierService->recupererOuCreerPanierPourUtilisateur($utilisateur->getId());
    
            // Passer la commande
            $this->panierService->passerCommande($utilisateur->getId(), $panierId);
    
            $_SESSION['success_message'] = 'Votre commande a été passée avec succès.';
            header('Location: /projet-vente-en-ligne/commande/historique');
            exit();
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: /projet-vente-en-ligne/panier');
            exit();
        }
    }
    

}
