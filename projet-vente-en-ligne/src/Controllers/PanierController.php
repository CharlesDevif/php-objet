<?php

namespace App\Controllers;

use App\Entity\Panier;
use App\Service\ProduitService;

class PanierController extends Controller
{
    public function __construct()
    {
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

    public function ajouter()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit'], $_POST['quantite'])) {
            $idProduit = (int)$_POST['id_produit'];
            $quantite = max((int)$_POST['quantite'], 1);

            $produitService = new ProduitService();
            $produit = $produitService->recupererProduitParId($idProduit);

            if ($produit && $produit->verifierStock($quantite)) {
                $panier = $this->getPanier();
                $panier->ajouterArticle($produit, $quantite);

                // Met à jour le stock
                $produitService->verifierEtMettreAJourStock($idProduit, $quantite);

                // Sauvegarde du panier
                $this->sauvegarderPanier($panier);
            } else {
                $_SESSION['erreur_panier'] = 'Stock insuffisant.';
            }
        }

        header('Location: /projet-vente-en-ligne/panier');
        exit();
    }

    public function index()
    {
        $panier = $this->getPanier();

        $this->render('panier/index', [
            'articles' => $panier->getArticles(),
            'total' => $panier->calculerTotal(),
        ], 'default');
    }

    public function retirer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit'], $_POST['quantite'])) {
            $idProduit = (int)$_POST['id_produit'];
            $quantite = max((int)$_POST['quantite'], 1);

            $produitService = new ProduitService();
            $produit = $produitService->recupererProduitParId($idProduit);

            if ($produit) {
                $panier = $this->getPanier();
                $panier->retirerArticle($produit, $quantite);

                // Sauvegarde du panier
                $this->sauvegarderPanier($panier);
            }
        }

        header('Location: /projet-vente-en-ligne/panier');
        exit();
    }
}
