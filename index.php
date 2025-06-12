<?php
// mettre la date et l'heure par défaut
date_default_timezone_set('Europe/Paris');


// Démarrer la session
session_start();

// mettre en place un cookie de session avec une durée de vie de 1h avec le nom 'sae202_id'
setcookie('sae202_id', session_id(), time() + 3600, '/');



require_once __DIR__ . '/conf/routeur.php';