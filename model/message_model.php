<?php

require_once $GLOBALS['conf_dir'] . "conf.inc.php";
require_once $GLOBALS['model_dir'] . "user_model.php";



function getUserSentMessages(int $userId): array
{
    global $dbInstance;

    // Récupérer les messages de l'utilisateur
    $query = "SELECT * FROM messages WHERE user_id = :user_id ORDER BY created_at DESC";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserReceivedMessages(int $userId): array
{
    global $dbInstance;

    // Récupérer les messages reçus par l'utilisateur
    $query = "SELECT * FROM messages WHERE destinataire_id = :user_id ORDER BY created_at DESC";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getMessageDestinataireInfos(int $messageId): ?array
{
    global $dbInstance;

    // Récupérer les informations du destinataire du message
    $query = "SELECT u.id, u.username, u.email FROM messages m
              JOIN users u ON m.destinataire_id = u.id
              WHERE m.id = :message_id";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':message_id', $messageId);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch();
    }

    return null; // Aucun destinataire trouvé pour ce message
}


function deleteMessage(int $messageId): bool
{
    global $dbInstance;

    // Supprimer le message de la base de données
    $query = "DELETE FROM messages WHERE id = :message_id";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':message_id', $messageId);

    return $stmt->execute();
}

function createMessage(int $userId, int $destinataire,  string $content): array
{
    global $dbInstance;

    // Vérifier si le destinataire existe
    $adminUsers = getAdminUsers();
    if (!in_array($destinataire, array_column($adminUsers, 'id'))) {
        return [
            'success' => false,
            'message' => 'Destinataire invalide.'
        ];
    }


    // Insérer un nouveau message dans la base de données
    $query = "INSERT INTO messages (user_id, destinataire, contenu, date_envoi, statut) 
              VALUES (:user_id, :destinataire, :contenu, NOW(), 'non lu')";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':destinataire', $destinataire);
    $stmt->bindParam(':contenu', $content);
     $stmt->execute();


    if ($stmt->rowCount() > 0) {
        return [
            'success' => true,
            'message' => 'Message envoyé avec succès.'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Erreur lors de l\'envoi du message.'
        ];
    }
}