<?php

namespace App\Controllers;

use App\Entity\Produit\Produit;
use App\Entity\Produit\ProduitNumerique;
use App\Entity\Produit\ProduitPerissable;
use App\Service\ProduitService;
use App\Entity\Produit\ProduitPhysique;
use Exception;

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
        if (!is_null($produit)) {
            try {
                $this->produitService->creerProduit($produit);
            } catch (Exception $err) {
                exit($err->getMessage());
            }
        }

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
        $prix = strip_tags($_POST['prix']);
        $stock = strip_tags($_POST['stock']);

        if (!is_numeric($prix) || !is_numeric($stock)) return null;

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
            $temperature = strip_tags($_POST['temperature']);

            if (!$dateExpiration || !is_numeric($temperature)) return null;

            return new ProduitPerissable($nom, $description, $prix, $stock, $dateExpiration, $temperature);
        } else if (isset($_POST['physique']) && isset($_POST['poids']) && isset($_POST['longueur']) && isset($_POST['largeur']) && isset($_POST['hauteur'])) {
            $poids = strip_tags($_POST['poids']);
            $longueur = strip_tags($_POST['longueur']);
            $largeur = strip_tags($_POST['largeur']);
            $hauteur = strip_tags($_POST['hauteur']);

            if (!is_numeric($poids) || !is_numeric($longueur) || !is_numeric($largeur) || !is_numeric($hauteur)) return null;

            return new ProduitPhysique($nom, $description, $prix, $stock, $poids, $longueur, $largeur, $hauteur);
        } else {
            return null;
        }
    }
}
