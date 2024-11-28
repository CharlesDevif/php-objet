<?php

namespace App\Core;

use App\Controllers\HomeController;

class Main
{
    public function start(string $uri)
    {
        // Démarrer la session
        session_start();

        // Diviser l'URI en segments
        $params = explode('/', trim($uri, '/'));

        // Vérifier si une route est définie
        $controllerName = !empty($params[0]) ? ucfirst(array_shift($params)) . 'Controller' : 'HomeController';
        $controllerClass = '\\App\\Controllers\\' . $controllerName;
        $action = !empty($params[0]) ? array_shift($params) : 'index';

        // Vérifier les droits d'accès
        if (!$this->estConnecte() && !$this->estRoutePublique($controllerName, $action)) {
            // Envoyer vers la méthode connexion du contrôleur Utilisateur
            $this->appelerControleur('\\App\\Controllers\\UtilisateurController', 'connexion');
            return;
        }

        // Appeler le contrôleur et l'action correspondante
        if (class_exists($controllerClass)) {
            $this->appelerControleur($controllerClass, $action, $params);
        } else {
            $this->render404();
        }
    }

    private function render404()
    {
        http_response_code(404);
        require_once ROOT . '/src/Views/404.php';
        exit();
    }

    private function estConnecte(): bool
    {
        return isset($_SESSION['utilisateur']);
    }

    private function estRoutePublique(string $controller, string $action): bool
    {
        // Liste des routes publiques avec contrôleur et méthode
        $routesPubliques = [
            'HomeController' => ['index'],
            'ProduitController' => ['index', 'add', 'supprimer', 'modifier'],
            'UtilisateurController' => ['connexion', 'inscription'],
        ];

        return isset($routesPubliques[$controller]) && in_array($action, $routesPubliques[$controller], false);
    }

    private function appelerControleur(string $controllerClass, string $action, array $params = [])
    {
        if (!class_exists($controllerClass)) {
            $this->render404();
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $action)) {
            $this->render404();
        }

        call_user_func_array([$controller, $action], $params);
    }
}
