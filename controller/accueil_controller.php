<?php

function index() : void {
    $title = "Accueil";
    $desc = "Page d'accueil du site  ";
    require_once $GLOBALS['view_dir'] . 'header.php';
    require_once $GLOBALS['view_dir'] . 'accueil_view.php';
    require_once $GLOBALS['view_dir'] . 'footer.php';
    
}