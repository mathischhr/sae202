<?php


$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Retirer le slash initial et final

$url = trim($url, '/');

// Diviser l'URL en segments
$items = explode('/', $url);

var_dump($items); // Pour déboguer, à supprimer en production


// Obtenir le contrôleur et l'action à partir de l'URL
$controller = !empty($items[0]) ? $items[0] : 'accueil';
$action = !empty($items[1]) ? $items[1] : 'index';

// vérifier l'action 2 
if (isset($items[2]) && !empty($items[2])) {
    $action = $items[2];
}

// Inclure le fichier de contrôleur approprié
$controllerFile =   '/controller/' . $controller . '_controller.php';
if (file_exists($controllerFile)) {
    include $controllerFile;
    if (function_exists($action)) {
        call_user_func($action);
    } else {
        include  'controller/error_404.php';
    }
} else {
    include 'controller/error_404.php';
}