<?php

function index() : void {
    // var_dump($_SERVER["REQUEST_SCHEME"]);
    $title = "Accueil";
    $desc = "Page d'accueil du site  ";
    require_once $GLOBALS['partials_dir'] . 'header.php';
    require_once $GLOBALS['view_dir'] . 'accueil_view.php';
    require_once $GLOBALS['partials_dir'] . 'footer.php';
    
}