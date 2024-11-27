<?php

use App\Core\Main;

// On définit une constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

require_once ROOT . '/vendor/autoload.php';

// On instancie Main (notre routeur)
$app = new Main();

// On démarre l'application
$app->start();
