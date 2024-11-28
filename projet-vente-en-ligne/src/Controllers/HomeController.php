<?php

namespace App\Controllers;

use App\Service\ProduitService;
use App\Entity\Panier;

class HomeController extends Controller
{
    private ProduitService $produitService;

    public function __construct()
    {
        $this->produitService = new ProduitService();

        // Initialisation du panier si non existant
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = serialize(new Panier());
        }
    }

    private function getPanier(): Panier
    {
        return unserialize($_SESSION['panier']);
    }

    private function sauvegarderPanier(Panier $panier): void
    {
        $_SESSION['panier'] = serialize($panier);
    }

    public function index()
    {
        $produits = $this->produitService->recupererProduitsAffichables();
        $this->render('home/index', ['produits' => $produits], 'default');
    }

    public function ajouterAuPanier()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit'])) {
            $idProduit = (int)$_POST['id_produit'];
            $quantite = 1; // Par défaut, ajout d'une unité

            $produit = $this->produitService->recupererProduitParId($idProduit);

            if ($produit && $produit->verifierStock($quantite)) {
                $panier = $this->getPanier();
                $panier->ajouterArticle($produit, $quantite);

                // Met à jour le stock
                $this->produitService->verifierEtMettreAJourStock($idProduit, $quantite);

                // Sauvegarde du panier
                $this->sauvegarderPanier($panier);

                $_SESSION['success_message'] = 'Produit ajouté au panier avec succès.';
            } else {
                $_SESSION['error_message'] = 'Stock insuffisant ou produit introuvable.';
            }
        }

        header('Location: /projet-vente-en-ligne/');
        exit();
    }
}
