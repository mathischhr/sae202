<?php
// mettre la date et l'heure par défaut
date_default_timezone_set('Europe/Paris');

// Démarrer la session
session_start();

// mettre en place un cookie de session avec une durée de vie de 1h avec le nom 'sae202_id'
setcookie('sae202_id', session_id(), time() + 3600, '/');


// les variables globales
$site_description = "Projet SAE202 2025 à l'IUT de Troyes - Agence Ollie - Esdras Onionkiton, Ethan Mauclair, Matthis Chhour, Mélissa Toumazet, Mohamad Edelbi";
$description_end = "  - par Agence Ollie ";
$canonicalUrl = 'https://mmi24f07.sae202.ovh';
$ogImage = 'https://mmi24f07.sae202.ovh/agence/wp-content/uploads/2025/06/e1c4b62ae9f2dcc8bf583d2844c00961bb751246-scaled.png';
$favicon = "https://mmi24f07.sae202.ovh/agence/wp-content/uploads/2025/06/cropped-Favicon__Ollie.png";

$directory = __DIR__ . "/";
$conf_dir = $directory . 'conf/';
$controller_dir = $directory . 'controller/';
$view_dir = $directory . 'view/';
$model_dir = $directory . 'model/';
$admin_dir = $directory . 'admin/';

require_once  $conf_dir . 'routeur.php';
