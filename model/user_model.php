<?php


require_once "conf/conf.inc.php";


function userExists(string $username): bool
{
    global $dbInstance;
    // Vérifier si l'utilisateur existe déjà dans la base de données
    $query = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :username";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    return $stmt->fetchColumn() > 0;
}



function create_user(string $username, string $password, string $email, ?string $role): array
{
    global $dbInstance;


    // Vérifier si l'utilisateur existe déjà
    if (userExists($username)) {
        return ['success' => false, 'message' => 'Cet username existe déjà. Impossible de le réutiiliser.'];
    }
    // Vérifier si l'email existe déjà

    if (userExists($email)) {
        return ['success' => false, 'message' => 'L\'utilisateur avec cet email existe déjà.'];
    }

    if (empty($username) || empty($password) || empty($email)) {
        return ['success' => false, 'message' => 'Tous les champs sont requis.'];
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Adresse e-mail invalide.'];
    }
    // Si le rôle n'est pas spécifié, on peut définir un rôle par défaut
    if (empty($role)) {
        $role = 'user';
    }

    // Hacher le mot de passe pour le stockage sécurisé
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Enregistrer l'utilisateur dans la base de données
    $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :pwd, :role )";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pwd', $hashedPassword);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        // L'utilisateur a été créé avec succès
        return ['success' => true, 'message' => 'Utilisateur créé avec succès.'];
    } else {
        // Une erreur s'est produite lors de la création de l'utilisateur
        return ['success' => false, 'message' => 'Erreur lors de la création de l\'utilisateur.'];
    }
}




/**
 * Fonction pour vérifier les informations d'identification de l'utilisateur
 *
 * @param string $username
 * @param string $password
 * @param bool $remember
 * @return array
 */
function login_user(string $username, string $password, bool $remember = true): array
{
    global $dbInstance;


    $user = getUser($username);

    //   var_dump($user);
    //   die();
    // Vérifier si l'utilisateur existe dans la base de données

    if (!$user) {
        return ['success' => false, 'message' => 'Utilisateur non trouvé.'];
    }


    // Récupérer le mot de passe haché de l'utilisateur;
    $hashedPassword = $user['password'];

    // Vérifier le mot de passe
    if (password_verify($password, $hashedPassword)) {

        unset($user['password']);

        $hashedToken = "";
        // Si l'utilisateur a choisi de rester connecté, on peut gérer le cookie
        if ($remember && $_SERVER['REQUEST_SCHEME']  === 'https') {

            // On suppose que l'utilisateur a un ID unique dans la base de données
            $userId = $user['id'];

            // Générer un jeton aléatoire sécurisé
            $token = bin2hex(random_bytes(32)); // 64 caractères hexadécimaux
            $hashedToken = password_hash($token, PASSWORD_DEFAULT); // Hasher le jeton pour le stocker en BDD

            // Enregistrer le jeton dans la base de données
           createUserToken($userId, $hashedToken);
            
        }
        // Authentification réussie
        return ['success' => true, 'message' => 'Authentification réussie.', 'token' => $hashedToken, 'user' => $user];
    } else {
        // Mot de passe incorrect
        return ['success' => false, 'message' => 'Mot de passe incorrect.'];
    }
}


function getUser(string $username): ?array
{
    global $dbInstance;

    // Récupérer les informations de l'utilisateur
    $query = "SELECT * FROM users WHERE username = :username OR email = :username";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch();
    }

    return null; // L'utilisateur n'existe pas
}

function getUserByToken(string $token): ?array
{
    global $dbInstance;

    // Récupérer l'utilisateur par le token le plus récent
    $query = "SELECT * FROM users u
              JOIN remember_tokens rt ON u.id = rt.user_id
              WHERE rt.token = :token AND rt.expires_at > NOW()
              ORDER BY rt.expires_at DESC LIMIT 1";

    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch();
    }

    return null; // Aucun utilisateur trouvé avec ce token
}


function createUserToken(int $userId, string $hashedToken): bool
{
    global $dbInstance;

    // Insérer ou mettre à jour le token de l'utilisateur dans la base de données
    $query = "INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (:userId, :token, DATE_ADD(NOW(), INTERVAL 10 DAY))
              ON DUPLICATE KEY UPDATE token = :token, expires_at = DATE_ADD(NOW(), INTERVAL 10 DAY)";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':token', $hashedToken);

    return $stmt->execute();
}



function updateUserToken(int $userId, string $newHashedToken): bool
{
    global $dbInstance;

    // Mettre à jour le token de l'utilisateur dans la base de données
    $query = "UPDATE remember_tokens SET token = :token, expires_at = DATE_ADD(NOW(), INTERVAL 10 DAY) WHERE user_id = :userId";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':token', $newHashedToken);
    $stmt->bindParam(':userId', $userId);

    return $stmt->execute();
}
