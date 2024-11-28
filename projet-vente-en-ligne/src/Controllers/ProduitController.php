<?php

namespace App\Controllers;

use App\Service\ProduitService;
use App\Entity\Produit\ProduitPhysique;

class ProduitController extends Controller
{
    private ProduitService $produitService;

    public function __construct(ProduitService $produitService)
    {
        $this->produitService = $produitService;
    }

    public function index()
    {
        $produits = $this->produitService->recupererTousLesProduits();
        $this->render('produit/index', ['produits' => $produits]);
    }

    public function ajouter()
    {
        // Exemple d'ajout d'un produit
        $produit = new ProduitPhysique(
            'Chaise en bois',
            'Chaise robuste et élégante',
            120.00,
            50,
            7.5,
            50.0,
            50.0,
            80.0
        );

        $this->produitService->creerProduit($produit);

        // Redirection vers la liste des produits après ajout
        header('Location: /projet-vente-en-ligne/produit');
        exit();
    }
}
