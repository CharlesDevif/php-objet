<?php

// Chargement de l'autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Définition de la constante ROOT
define('ROOT', dirname(__DIR__));

// Extraction de l'URI sans query string
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Nettoyage du préfixe `/projet-vente-en-ligne/` et suppression des slashes inutiles
$basePath = '/projet-vente-en-ligne';
$uri = substr($uri, strlen($basePath));
$uri = trim($uri, '/');

// Inclusion du routeur principal
use App\Core\Main;

$app = new Main();
$app->start($uri);
