<?php

require_once $GLOBALS['model_dir'] . 'user_model.php';
require_once $GLOBALS['helpers_dir'] . 'form_sanitizer.php';


function index(): void
{
    $title = "Connexion";
    $desc = "Veuillez vous connecter pour accéder à l'espace d'administration.";

    // Vérifier si l'utilisateur est déjà connecté
    if (isset($_SESSION['db_user'])) {
        $_SESSION['errorMessage'] = 'Vous êtes déjà connecté.';
        header('Location: /');
        exit;
    }

    require_once $GLOBALS['partials_dir'] . 'header.php';
    require_once $GLOBALS['view_dir'] . 'connexion_view.php';
    require_once $GLOBALS['partials_dir'] . 'footer.php';
}


function formHandle(): void
{

    // Gérer la soumission du formulaire de connexion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = sanitizeInput($_POST['username']) ?? '';
        $password = sanitizeInput($_POST['password']) ?? '';
        if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
            $remember = true;
        } else {
            $remember = false;
        }

        $response = login_user($username, $password, $remember);

        if ($response['success']) {

            if ($_SERVER['REQUEST_SCHEME'] === 'https') {
                $cookieName = 'remember_user_token';
                $expiration = time() + (86400 * 30); // 30 jours
                $path = '/'; // Disponible sur tout le site
                $domain = $GLOBALS['siteDomain'] ?? ''; // Utiliser le domaine du site si défini
                $secure = true; // IMPORTANT: N'envoyer le cookie qu'en HTTPS
                $httponly = true; // IMPORTANT: Empêche l'accès au cookie via JavaScript (XSS)
                $samesite = 'Lax'; // Ajouté pour la sécurité (Strict, Lax, None)

                setcookie($cookieName, $response['token'], [
                    'expires' => $expiration,
                    'path' => $path,
                    'domain' => $domain, // Si vide, le domaine courant sera utilisé
                    'secure' => $secure,
                    'httponly' => $httponly,
                    'samesite' => $samesite
                ]);
            }

            $_SESSION['db_user'] = $username;
            $_SESSION['successMessage'] = 'Connexion réussie.';
            header('Location: /', true, 302);
            exit;
        } else {
            $_SESSION['errorMessage'] =  $response['message'];;
            header('Location: /connexion');
            exit;
        }
    } else {
        $_SESSION['errorMessage'] = 'Méthode de requête non autorisée.';
        header('Location: /connexion');
        exit;
    }
}

function logout(): void
{
    unset($_SESSION['db_user']);
    $_SESSION['successMessage'] = 'Déconnexion réussie.';
    header('Location: /', true, 302);
    exit;
}
