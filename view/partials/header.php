<?php

$site_description =  (isset($desc) && ! empty($desc)) ?  $desc . $GLOBALS['description_end'] : $GLOBALS['site_description'];

$title =  isset($title) ? $title . "  | Disco Murder by Ollie " : '  Disco Murder by Ollie ';

// Utiliser la variable globale si la variable n'a pas été surchargée
if (!isset($canonicalUrl) && isset($GLOBALS['canonicalUrl'])) {
    $canonicalUrl = $GLOBALS['canonicalUrl'];
}
if (!isset($ogImage) && isset($GLOBALS['ogImage'])) {
    $ogImage = $GLOBALS['ogImage'];
}

if (!isset($favicon) && isset($GLOBALS['favicon'])) {
    $favicon = $GLOBALS['favicon'];
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $site_description ?>">
    <meta name="author" content="Esdras Onionkiton, Ethan Mauclair, Matthis Chhour, Mélissa Toumazet, Mohamad Edelbi">
    <meta name="author-url" content="mmi24f07.mmi-troyes.fr, mmi24e12.mmi-troyes.fr, mmi24h06.mmi-troyes.fr, mmi24c07.mmi-troyes.fr">
    <meta name="author-email" content="mmi24f07@mmi-troyes.fr, mmi24e12@mmi-troyes.fr, mmi24b09@mmi-troyes.fr, mmi24h06@mmi-troyes.fr, mmi24c07@mmi-troyes.fr">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title; ?></title>

    <!-- Lien canonique -->
    <link rel="canonical" href="<?= $canonicalUrl; ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= $title; ?>">
    <meta property="og:description" content="<?= $site_description; ?>">
    <meta property="og:image" content="<?= $ogImage; ?>">
    <meta property="og:url" content="<?= $canonicalUrl; ?>">
    <meta property="og:type" content="website">

    <link rel="stylesheet" href="/view/partials/css/global.css">
    <link rel="stylesheet" href="/view/partials/css/header.css">
    <link rel="stylesheet" href="/view/partials/css/main.css">
    <link rel="stylesheet" href="/view/partials/css/profile.css">
    <link rel="shortcut icon" href="<?= $favicon; ?>" type="image/x-icon">


</head>

<body>


    <header>
        <div class="logo">
            <a href="/"><img src="<?= $ogImage; ?>" alt="Logo  du site"></a>
        </div>
        <nav>
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="/concept">Concept</a></li>
                <li><a href="/infos-pratiques">Infos pratiques</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="/profile">Mon profile</a></li>
                    <li><a href="/profile/messagerie">Messagerie</a></li>
                    <li><a href="/connexion/logout">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="/inscription">Inscription </a></li>
                    <li><a href="/connexion">Connexion</a></li>
                <?php endif; ?>
                <li><a href="/agence" target="_blank">Ollie Agence</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <div class="flash-messages">
            <?php
            // Afficher les messages de session
            if (isset($_SESSION['successMessage'])) {
                echo '<div class="success-message">' . htmlspecialchars($_SESSION['successMessage']) . '</div>';
                unset($_SESSION['successMessage']);
            }
            if (isset($_SESSION['errorMessage'])) {
                echo '<div class="error-message">' . htmlspecialchars($_SESSION['errorMessage']) . '</div>';
                unset($_SESSION['errorMessage']);
            }
            ?>
        </div>