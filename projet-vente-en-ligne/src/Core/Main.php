<?php

namespace App\Core;

use App\Controllers\HomeController;

class Main
{
    public function start(string $uri)
    {
        // Diviser l'URI en segments
        $params = explode('/', $uri);

        if (!empty($params[0])) {
            // Premier segment : nom du contrôleur
            $controllerName = ucfirst(array_shift($params)) . 'Controller';
            $controllerClass = '\\App\\Controllers\\' . $controllerName;

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();

                // Deuxième segment : nom de l'action
                $action = array_shift($params) ?? 'index';

                if (method_exists($controller, $action)) {
                    call_user_func_array([$controller, $action], $params);
                } else {
                    http_response_code(404);
                    echo "Méthode '$action' introuvable dans le contrôleur '$controllerName'.";
                }
            } else {
                http_response_code(404);
                echo "Contrôleur '$controllerName' introuvable.";
            }
        } else {
            // Aucun paramètre : contrôleur par défaut
            $controller = new HomeController();
            $controller->index();
        }
    }
}
