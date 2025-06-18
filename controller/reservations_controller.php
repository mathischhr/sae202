<?php

require_once $GLOBALS['model_dir'] . 'reservation_model.php';
require_once $GLOBALS['model_dir'] . 'event_model.php';
require_once $GLOBALS['helpers_dir'] . 'form_sanitizer.php';


function index(): void
{
    $title = "Mes réservations";
    $desc = "Gérez vos réservations.";

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        $_SESSION['errorMessage'] = 'Vous devez être connecté pour accéder à cette page.';
        header('Location: /connexion');
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $reservations = getUserReservations($userId);

    require_once $GLOBALS['partials_dir'] . 'header.php';
    require_once $GLOBALS['view_dir'] . 'reservations_view.php';
    require_once $GLOBALS['partials_dir'] . 'footer.php';
}

function create(): void{
    $title = "Nouvelle réservation";
    $desc = "Créez une nouvelle réservation.";

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        $_SESSION['errorMessage'] = 'Vous devez être connecté pour créer une réservation.';
        header('Location: /connexion');
        exit;
    }

    $userId = $_SESSION['user']['id'];

    $event = getEventBySearch();

  //  var_dump($event);

    // Vérifier si les données du formulaire sont soumises
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'user_id' => $userId,
            'event_id' => (int) sanitizeInput($_POST['event_id'] ?? ''),
            'date_reservation' => sanitizeInput($_POST['date_reservation'] ?? ''),
            'nb_places' => (int) sanitizeInput($_POST['nb_places'] ?? 1),
            'is_group' => isset($_POST['is_group']) ? (int)$_POST['is_group'] : 0,
        ];

        var_dump($data);
        die('createReservation');
        $response = createReservation($userId, $data);

        if ($response['success']) {
            $_SESSION['successMessage'] = $response['message'];
            header('Location: /reservations');
            exit;
        } else {
            $_SESSION['errorMessage'] = $response['message'];
        }
    }

    require_once $GLOBALS['partials_dir'] . 'header.php';
    require_once $GLOBALS['view_dir'] . 'reservations_new_view.php';
    require_once $GLOBALS['partials_dir'] . 'footer.php';
}


