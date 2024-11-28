<?php

namespace App\Controllers;

use App\Service\ProduitService;
use App\Entity\Produit\ProduitPhysique;

class ProduitController extends Controller
{
    private ProduitService $produitService;

    public function __construct()
    {
        $this->produitService = new ProduitService();
    }

    public function index()
    {
        $produits = $this->produitService->recupererTousLesProduits();
        $this->render('produits/index', [
            'title' => 'Produits',
            'produits' => $produits
        ]);
    }

    public function add()
    {
        if (isset($_POST['submit'])) {
            print_r($_POST);
        } else {
            echo "Aucune données dans POST";
        }

        die();

        //$this->produitService->creerProduit($produit);

        // Redirection vers la liste des produits après ajout
        // header('Location: /projet-vente-en-ligne/produit');
        // exit();
    }
}
