<?php

namespace App\Controllers;

use App\Service\CategorieService;
use App\Factory\CategorieFactory;

class CategorieController extends Controller
{
    private CategorieService $categorieService;

    public function __construct()
    {
        $this->categorieService = new CategorieService();

        // Vérification d'accès
        if (!$this->verifierRole(['ROLE_ADMIN', 'ROLE_VENDEUR'])) {
            header('Location: /projet-vente-en-ligne/');
            exit();
        }
    }

    private function verifierRole(array $roles): bool
    {
        if (!isset($_SESSION['utilisateur'])) {
            return false;
        }

        $utilisateur = unserialize($_SESSION['utilisateur']);
        foreach ($roles as $role) {
            if (in_array($role, $utilisateur->getRoles())) {
                return true;
            }
        }

        return false;
    }




    public function index()
    {
        $categories = $this->categorieService->recupererToutesLesCategories();
        $this->render('categories/index', [
            'title' => 'Liste des catégories',
            'categories' => $categories
        ]);
    }

    public function produits(int $categorieId)
    {
        $categorie = $this->categorieService->recupererCategorieParId($categorieId);
        $produits = $this->categorieService->recupererProduitsParCategorie($categorieId);

        // Récupérer l'utilisateur connecté depuis la session
        $utilisateur = isset($_SESSION['utilisateur']) ? unserialize($_SESSION['utilisateur']) : null;

        $this->render('categories/produits', [
            'title' => 'Produits dans la catégorie',
            'categorie' => $categorie,
            'produits' => $produits,
            'utilisateur' => $utilisateur,
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $donnees = [
                'nom' => strip_tags($_POST['nom']),
                'description' => strip_tags($_POST['description'])
            ];

            $categorie = CategorieFactory::creerCategorie($donnees);

            try {
                $this->categorieService->creerCategorie($categorie);
                header('Location: /projet-vente-en-ligne/categorie');
                exit();
            } catch (\Exception $e) {
                $this->render('categories/add', [
                    'title' => 'Créer une catégorie',
                    'erreur' => $e->getMessage()
                ]);
            }
        } else {
            $this->render('categories/add', ['title' => 'Créer une catégorie']);
        }
    }

    public function modifier(int $id)
    {
        $categorie = $this->categorieService->recupererCategorieParId($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categorie->setNom(strip_tags($_POST['nom']));
            $categorie->setDescription(strip_tags($_POST['description']));

            try {
                $this->categorieService->mettreAJourCategorie($categorie);
                header('Location: /projet-vente-en-ligne/categorie');
                exit();
            } catch (\Exception $e) {
                $this->render('categories/edit', [
                    'title' => 'Modifier la catégorie',
                    'categorie' => $categorie,
                    'erreur' => $e->getMessage()
                ]);
            }
        } else {
            $this->render('categories/edit', [
                'title' => 'Modifier la catégorie',
                'categorie' => $categorie
            ]);
        }
    }

    public function ajouterProduit(int $categorieId)
    {
        $categorie = $this->categorieService->recupererCategorieParId($categorieId);

        if (!$categorie) {
            header('Location: /projet-vente-en-ligne/categorie');
            exit();
        }

        $produitService = new \App\Service\ProduitService();
        $produitsDisponibles = $produitService->recupererTousLesProduits();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produitId = (int)$_POST['produit_id'];

            try {
                $this->categorieService->associerProduitCategorie($produitId, $categorieId);
                header("Location: /projet-vente-en-ligne/categorie/produits/$categorieId");
                exit();
            } catch (\Exception $e) {
                $this->render('categories/ajouterProduit', [
                    'title' => 'Ajouter un produit à la catégorie',
                    'categorie' => $categorie,
                    'produitsDisponibles' => $produitsDisponibles,
                    'erreur' => $e->getMessage(),
                ]);
                return;
            }
        }

        $this->render('categories/ajouterProduit', [
            'title' => 'Ajouter un produit à la catégorie',
            'categorie' => $categorie,
            'produitsDisponibles' => $produitsDisponibles,
        ]);
    }

    public function supprimerProduit(int $categorieId, int $produitId)
    {
        try {
            $this->categorieService->supprimerProduitDeCategorie($produitId, $categorieId);
            header("Location: /projet-vente-en-ligne/categorie/produits/$categorieId");
            exit();
        } catch (\Exception $e) {
            $categorie = $this->categorieService->recupererCategorieParId($categorieId);
            $produits = $this->categorieService->recupererProduitsParCategorie($categorieId);

            $this->render('categories/produits', [
                'title' => 'Produits dans la catégorie',
                'categorie' => $categorie,
                'produits' => $produits,
                'erreur' => $e->getMessage(),
            ]);
        }
    }




    public function afficherProduitsParCategorie(int $categorieId)
    {
        $categorie = $this->categorieService->recupererCategorieParId($categorieId);

        if (!$categorie) {
            header('Location: /projet-vente-en-ligne/categorie');
            exit();
        }

        $produits = $this->categorieService->recupererProduitsParCategorie($categorieId);

        $this->render('categories/produits', [
            'title' => "Produits de la catégorie : " . htmlspecialchars($categorie->getNom()),
            'categorie' => $categorie,
            'produits' => $produits,
        ]);
    }

    public function supprimer(int $id)
    {
        $this->categorieService->supprimerCategorie($id);
        header('Location: /projet-vente-en-ligne/categorie');
        exit();
    }
}
