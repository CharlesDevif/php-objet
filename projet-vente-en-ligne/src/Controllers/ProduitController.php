<?php

namespace App\Controllers;

use App\Entity\Produit\Produit;
use App\Entity\Produit\ProduitNumerique;
use App\Entity\Produit\ProduitPerissable;
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
        $produit = $this->verificationDesChamps();
        if (!is_null($produit)) $this->produitService->creerProduit($produit);

        // Redirection après l'ajout
        header('Location: /projet-vente-en-ligne/produit');
        exit();
    }

    public function supprimer($id)
    {
        $this->produitService->supprimerProduit((int)$id);
        header('Location: /projet-vente-en-ligne/produit');
        exit();
        // Redirection vers la liste des produits après ajout
        // header('Location: /projet-vente-en-ligne/produit');
        // exit();
    }

    private function verificationDesChamps(): ?Produit
    {
        if (!isset($_POST['nom']) || !isset($_POST['description']) || !isset($_POST['prix']) || !isset($_POST['stock'])) {
            return null;
        }

        $nom = strip_tags($_POST['nom']);
        $description = strip_tags($_POST['description']);
        $prix = (float) strip_tags($_POST['prix']);
        $stock = (int) strip_tags($_POST['stock']);

        if (isset($_POST['numerique'])) {
            if ($_FILES['file']['error'] > 0) {
                return null;
            }

            $formatFichier = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
            $nomFichier = $_FILES['file']['name'];
            $tmpName = $_FILES['file']['tmp_name'];


            $tailleFichier = (float) $_FILES['file']['size'];
            $lienTelechargement = ROOT . "/public/uploads/" . $nomFichier;
            $result = move_uploaded_file($tmpName, $lienTelechargement);

            if (!$result) {
                return null;
            }

            return new ProduitNumerique($nom, $description, $prix, $stock, $lienTelechargement, $tailleFichier, $formatFichier);
        } else if (isset($_POST['perissable']) && isset($_POST['dateExpiration']) && isset($_POST['temperature'])) {
            $dateExpiration = \DateTime::createFromFormat("Y-m-d", strip_tags($_POST['dateExpiration']));
            $temperature = (float) strip_tags($_POST['temperature']);

            if (!$dateExpiration) return null;

            return new ProduitPerissable($nom, $description, $prix, $stock, $dateExpiration, $temperature);
        } else {
            return null;
        }
    }
}
