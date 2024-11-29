<?php

namespace App\Controllers;

use App\Service\PanierService;


abstract class Controller
{
    public function genererLayout()
    {
        $panierService = new PanierService();
        $utilisateur = isset($_SESSION['utilisateur']) ? unserialize($_SESSION['utilisateur']) : null;

        $compteurArticles = 0;
        if ($utilisateur) {
            try {
                $panierId = $panierService->recupererOuCreerPanierPourUtilisateur($utilisateur->getId());
                $compteurArticles = $panierService->compterArticles($panierId);
            } catch (\Exception $e) {
                $compteurArticles = 0; // Gestion des erreurs
            }
        }

        return [
            'utilisateur' => $utilisateur,
            'compteurArticles' => $compteurArticles,
        ];
    }

    public function render(string $fichier, array $donnees = [], string $template = 'default')
    {
        // Générer les données pour le layout
        $layoutData = $this->genererLayout();

        // Fusionner les données spécifiques à la vue et les données globales
        extract(array_merge($layoutData, $donnees));

        // Charger le contenu de la vue
        ob_start();
        require_once ROOT . "/src/Views/" . $fichier . '.php';
        $contenu = ob_get_clean();

        // Inclure le template
        require_once ROOT . "/src/Views/" . $template . '.php';
    }
}
