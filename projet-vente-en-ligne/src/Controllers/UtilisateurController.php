<?php

namespace App\Controllers;

use App\Service\UtilisateurService;
use App\Repository\UtilisateurRepository;

class UtilisateurController extends Controller
{
    private UtilisateurService $utilisateurService;

    public function __construct()
    {
        $this->utilisateurService = new UtilisateurService(new UtilisateurRepository());
    }

    public function connexion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $motDePasse = $_POST['mot_de_passe'];

            $utilisateur = $this->utilisateurService->connexion($email, $motDePasse);

            if ($utilisateur) {
                $_SESSION['utilisateur'] = serialize($utilisateur); // Sérialiser l'objet utilisateur
                header('Location: /projet-vente-en-ligne/');
                exit();
            } else {
                $erreur = 'Email ou mot de passe incorrect.';
            }
        }

        $this->render('utilisateur/connexion', ['erreur' => $erreur ?? null, 'title' => 'Connexion']);
    }

    public function inscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'] ?? 'client';

            try {
                $idUtilisateur = $this->utilisateurService->inscription($_POST, $type);

                // Redirige vers la page de connexion après l'inscription
                header('Location: /projet-vente-en-ligne/utilisateur/connexion');
                exit();
            } catch (\InvalidArgumentException $e) {
                // Affiche les erreurs de validation
                $this->render('utilisateur/inscription', ['erreur' => $e->getMessage()]);
            }
        } else {
            $this->render('utilisateur/inscription', ['title' => 'Inscription']);
        }
    }


    public function dashboard()
    {
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: /projet-vente-en-ligne/utilisateur/connexion');
            exit();
        }

        // Désérialiser l'utilisateur depuis la session
        $utilisateur = unserialize($_SESSION['utilisateur']);

        if (!$utilisateur || !$utilisateur instanceof \App\Entity\Utilisateur\Utilisateur) {
            session_destroy();
            header('Location: /projet-vente-en-ligne/utilisateur/connexion');
            exit();
        }

        if ($this->utilisateurService->verifierRole($utilisateur, 'ROLE_ADMIN')) {
            $this->render('utilisateur/admin_dashboard', ['utilisateur' => $utilisateur]);
        } elseif ($this->utilisateurService->verifierRole($utilisateur, 'ROLE_CLIENT')) {
            $this->render('utilisateur/client_dashboard', ['utilisateur' => $utilisateur]);
        } elseif ($this->utilisateurService->verifierRole($utilisateur, 'ROLE_VENDEUR')) {
            $this->render('utilisateur/vendeur_dashboard', ['utilisateur' => $utilisateur]);
        } else {
            http_response_code(403);
            echo "Accès refusé.";
        }
    }


    public function deconnexion()
    {
        session_destroy();
        header('Location: /projet-vente-en-ligne/utilisateur/connexion');
        exit();
    }
}
