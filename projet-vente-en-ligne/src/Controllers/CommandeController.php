<?php

namespace App\Controllers;

use App\Service\CommandeService;

class CommandeController extends Controller
{
    private CommandeService $commandeService;

    public function __construct()
    {
        $this->commandeService = new CommandeService();
    }

    public function historique()
    {
        $this->verifierUtilisateur();

        try {
            $utilisateur = unserialize($_SESSION['utilisateur']);
            $commandes = $this->commandeService->recupererCommandesUtilisateur($utilisateur->getId());

            $this->render('commande/historique', [
                'commandes' => $commandes,
            ], 'default');
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: /projet-vente-en-ligne/');
            exit();
        }
    }

    public function detail(int $commandeId)
    {
        $this->verifierUtilisateur();

        try {
            $utilisateur = unserialize($_SESSION['utilisateur']);
            $commande = $this->commandeService->recupererCommandeParId($commandeId, $utilisateur->getId());

            $this->render('commande/detail', [
                'commande' => $commande,
            ], 'default');
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: /projet-vente-en-ligne/commande/historique');
            exit();
        }
    }

    private function verifierUtilisateur(): void
    {
        if (!isset($_SESSION['utilisateur'])) {
            $_SESSION['error_message'] = 'Vous devez être connecté pour accéder à vos commandes.';
            header('Location: /projet-vente-en-ligne/utilisateur/connexion');
            exit();
        }
    }
}
