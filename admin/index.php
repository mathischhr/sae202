<?php


    $title = 'Accès administration';
    $desc = 'Bienvenue dans l\'espace d\'administration de Disco';

    $connectedUser = isset($_SERVER['REMOTE_USER']) ? $_SESSION['REMOTE_USER'] : null;
    
    foreach ($_SERVER as $key => $value) {
        echo $key . ': ' . $value . "<br>"; // Pour déboguer, à supprimer en production

    }

    if ($connectedUser) {
        $desc .= '   - Utilisateur connecté : ' . htmlspecialchars($connectedUser);
    } else {
        $desc .= ' - Aucun utilisateur connecté';
    }

    // $partials_dir = 

    echo '<h1>' . htmlspecialchars($title) . '</h1>';
    echo '<p>' . htmlspecialchars($desc) . '</p>';

    // include $GLOBALS['partials_dir'] . 'header.php';
    // include $GLOBALS['view_dir'] . 'admin/index_view.php';
    // include $GLOBALS['partials_dir'] . 'footer.php';
