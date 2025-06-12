<?php

function index() : void {
    $title = "Accueil";
    $desc = "Page d'accueil du site  !";
    require_once '/view/partials/header.php';
    require_once 'view/accueil_view.php';
    require_once '/view/partials/footer.php';
    
}