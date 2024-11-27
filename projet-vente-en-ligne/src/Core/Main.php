<?php

namespace App\Core;

use App\Controllers\HomeController;

/**
 * Routeur principal
 */
class Main
{
    public function start()
    {
        // On démarre la session
        session_start();

        // On récupère l'URI complète
        $uri = $_SERVER['REQUEST_URI'];

        // On supprime le "trailing slash" éventuel
        if (!empty($uri) && $uri !== '/' && substr($uri, -1) === '/') {
            $uri = substr($uri, 0, -1);

            // On redirige vers l'URL sans le slash final
            http_response_code(301);
            header('Location: ' . $uri);
            exit();
        }

        // Définir le chemin de base si l'application est dans un sous-dossier
        $basePath = '/projet-vente-en-ligne'; // Ajustez ce chemin selon votre configuration

        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        // Supprimer le premier slash s'il existe
        $uri = ltrim($uri, '/');

        // Séparer les segments de l'URI
        $params = explode('/', $uri);

        // Gestion des routes
        if (!empty($params[0])) {
            // On a au moins 1 paramètre : contrôleur
            $controllerName = ucfirst(array_shift($params)) . 'Controller';
            $controllerClass = '\\App\\Controllers\\' . $controllerName;

            // Vérification de l'existence du contrôleur
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();

                // On récupère la méthode (action) ou on utilise "index" par défaut
                $action = array_shift($params) ?? 'index';

                // Vérification de l'existence de la méthode
                if (method_exists($controller, $action)) {
                    // Appel de la méthode avec les éventuels paramètres
                    call_user_func_array([$controller, $action], $params);
                } else {
                    http_response_code(404);
                    echo "La méthode '$action' n'existe pas dans le contrôleur '$controllerName'.";
                }
            } else {
                http_response_code(404);
                echo "Le contrôleur '$controllerName' n'existe pas.";
            }
        } else {
            // Aucun paramètre, on appelle le contrôleur par défaut (HomeController)
            $controller = new HomeController();
            $controller->index();
        }
    }
}
