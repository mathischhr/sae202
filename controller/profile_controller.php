<?php


require_once $GLOBALS['model_dir'] . "profile_model.php";
require_once $GLOBALS['model_dir'] . "message_model.php";

require_once $GLOBALS['helpers_dir'] . "form_sanitizer.php";


function index(): void
{
    $title = "Mon profile";
    $desc = "Gérez votre profile utilisateur.";

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        $_SESSION['errorMessage'] = 'Vous devez être connecté pour accéder à cette page.';
        header('Location: /connexion');
        exit;
    }

    $userProfile = getUserProfile($_SESSION['user']['id']);
    if (!$userProfile) {
        $_SESSION['errorMessage'] = 'Impossible de récupérer les informations de votre profil.';
        header('Location: /');
        exit;
    }
    // Vérifier si l'utilisateur a un rôle d'admin
    if (isset($userProfile['role']) && $userProfile['role'] === 'admin') {
        $isAdmin = true;


        // Vérifier si l'utilisateur a une invitation en attente
        if($userProfile['valid_admin'] === 0) {
            $invitationToken = $userProfile['admin_invitation_token'];
            if ($invitationToken) {
              
                // générer l'URL de vérification
                $verificationUrl = "/profile/invitationVerification?token=" . urlencode($invitationToken);
                $message = "Vous avez une invitation en attente. Veuillez la valider en cliquant sur le lien suivant : <a href='$verificationUrl'>Valider l'invitation</a>";
                $_SESSION['errorMessage'] = $message;
            } 
        } 


    } else {
        $isAdmin = false;
    }


    require_once $GLOBALS['partials_dir'] . 'header.php';
    require_once $GLOBALS['view_dir'] . 'profile_view.php';
    require_once $GLOBALS['partials_dir'] . 'footer.php';
}


function messagerie(): void
{
    $title = "Messagerie";
    $desc = "Gérez vos messages.";

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        $_SESSION['errorMessage'] = 'Vous devez être connecté pour accéder à cette page.';
        header('Location: /connexion');
        exit;
    }

    require_once $GLOBALS['partials_dir'] . 'header.php';
    require_once $GLOBALS['view_dir'] . 'profile_messagerie_view.php';
    require_once $GLOBALS['partials_dir'] . 'footer.php';
}

function update(): void
{
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        $_SESSION['errorMessage'] = 'Vous devez être connecté pour mettre à jour votre profile.';
        header('Location: /connexion');
        exit;
    }

    $userId = $_SESSION['user']['id'];
    // Récupérer les données du formulaire
    $data = [
        'user_id' => $userId,
        'nom' => sanitizeInput($_POST['nom'] ?? ''),
        'prenom' => sanitizeInput($_POST['prenom'] ?? ''),
        'email' => sanitizeInput($_POST['email'] ?? ''),
        'date_naissance' => sanitizeDate($_POST['date_naissance'] ?? ''),
        'tel' => sanitizeInput($_POST['tel'] ?? ''),
        'adresse_rue' => sanitizeInput($_POST['adresse_rue'] ?? ''),
        'adresse_ville' => sanitizeInput($_POST['adresse_ville'] ?? ''),
        'adresse_cp' => sanitizeInput($_POST['adresse_cp'] ?? ''),
    ];

    $response = updateUserProfile($userId, $data);

    // Vérifier si la mise à jour a réussi
    if ($response['success']) {
        $_SESSION['successMessage'] = $response['message'];
    } else {
        $_SESSION['errorMessage'] = $response['message'];
    }

    header('Location: /profile');
    exit;
}

function invitationVerification(): void
{
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        $_SESSION['errorMessage'] = 'Vous devez être connecté pour accéder à cette page.';
        header('Location: /connexion');
        exit;
    }

    $userId = $_SESSION['user']['id'];

    // Vérifier si l'utilisateur a un rôle d'admin
    if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
        $_SESSION['errorMessage'] = 'Vous devez être un administrateur pour valider une invitation.';
        header('Location: /profile');
        exit;
    }
    
    // Récupérer le profil de l'utilisateur
    $userProfile = getUserProfile($userId);

    //  Vérifier si le token n'est pas déjà validé
    if (isset($userProfile['valid_admin']) && $userProfile['valid_admin'] === 1) {
        $_SESSION['errorMessage'] = 'Vous avez déjà validé cette invitation.';
        header('Location: /profile');
        exit;
    }

    $token = $_GET['token'] ?? '';
    $verif = verifyUserAdminInvitation($token);

    if ($verif['success']) {
        $_SESSION['successMessage'] = $verif['message'];
        header('Location: /profile');
        exit;
    } else {
        $_SESSION['errorMessage'] = $verif['message'];
        header('Location: /profile');
        exit;
    }
}
