<?php

namespace App\Controllers;

use App\Service\ProduitService;
use App\Service\PanierService;

class HomeController extends Controller
{
    private ProduitService $produitService;
    private PanierService $panierService;

    public function __construct()
    {
        $this->produitService = new ProduitService();
        $this->panierService = new PanierService();
    }

    public function index()
    {
        try {
            // Récupérer les catégories et les produits sans catégorie
            $categories = $this->produitService->recupererProduitsParCategorie();
            $produitsSansCategorie = $this->produitService->recupererProduitsSansCategorie();
    
            $this->render('home/index', [
                'categories' => $categories,
                'produitsSansCategorie' => $produitsSansCategorie,
            ], 'default');
        } catch (\Exception $e) {
            $_SESSION['error_message'] = "Erreur lors du chargement des produits : " . $e->getMessage();
            $this->render('home/index', [
                'categories' => [],
                'produitsSansCategorie' => [],
            ], 'default');
        }
    }
    

    

    public function ajouterAuPanier()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit'])) {
            $idProduit = (int)$_POST['id_produit'];
            $quantite = 1; // Par défaut, ajouter 1 unité

            try {
               

                $utilisateur = unserialize($_SESSION['utilisateur']);
                $utilisateurId = $utilisateur->getId();

                // Vérifiez l'existence du produit
                $produit = $this->produitService->recupererProduitParId($idProduit);

                if (!$produit || !$produit->verifierStock($quantite)) {
                    throw new \Exception('Stock insuffisant ou produit introuvable.');
                }

                // Récupérer ou créer le panier pour l'utilisateur connecté
                $panierId = $this->panierService->recupererOuCreerPanierPourUtilisateur($utilisateurId);

                // Ajouter le produit au panier
                $this->panierService->ajouterArticle($panierId, $idProduit, $quantite);

                $_SESSION['success_message'] = 'Produit ajouté au panier avec succès.';
            } catch (\Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
            }
        }

        header('Location: /projet-vente-en-ligne/');
        exit();
    }
    
}
