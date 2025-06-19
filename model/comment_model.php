<?php

require_once $GLOBALS['conf_dir'] . "conf.inc.php";
require_once $GLOBALS['model_dir'] . "user_model.php";


function getUserComments(int $userId): ?array
{
    global $dbInstance;

    // Vérifier si l'utilisateur existe
    if (!getUserById($userId)) {
        return null; // L'utilisateur n'existe pas
    }

    // Récupérer les commentaires de l'utilisateur
    $query = "SELECT * FROM comments WHERE user_id = :user_id ORDER BY date DESC";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return null; // Aucun commentaire trouvé pour cet utilisateur
  
}

function createComment(int $userId, string $content): array
{
    global $dbInstance;

    // Vérifier si l'utilisateur existe
    if (!getUserById($userId)) {
        return ['success' => false, 'message' => 'Utilisateur non trouvé.'];
    }

    // Insérer le commentaire dans la base de données
    $query = "INSERT INTO comments (user_id, content, deleted, archived, date) VALUES (:user_id, :content, 0, 0, NOW())";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Commentaire créé avec succès.'];
    } else {
        return ['success' => false, 'message' => 'Erreur lors de la création du commentaire.'];
    }
}


function getCommentById(int $commentId): ?array
{
    global $dbInstance;

    // Récupérer le commentaire par son ID
    $query = "SELECT * FROM comments WHERE id = :comment_id";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':comment_id', $commentId);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return null; // Aucun commentaire trouvé avec cet ID
}

function deleteComment(int $commentId): array
{
    global $dbInstance;

    // Vérifier si le commentaire existe
    $comment = getCommentById($commentId);
    if (!$comment) {
        return ['success' => false, 'message' => 'Commentaire non trouvé.'];
    }
  

    // Supprimer le commentaire
    $query = "DELETE FROM comments WHERE id = :comment_id";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':comment_id', $commentId);

    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Commentaire supprimé avec succès.'];
    } else {
        return ['success' => false, 'message' => 'Erreur lors de la suppression du commentaire.'];
    }
}


function updateComment(int $commentId, string $content): array
{
    global $dbInstance;

    // Vérifier si le commentaire existe
    $comment = getCommentById($commentId);
    if (!$comment) {
        return ['success' => false, 'message' => 'Commentaire non trouvé.'];
    }

    // Mettre à jour le commentaire
    $query = "UPDATE comments SET content = :content, statut = :statut, archived = :archived, date = NOW() WHERE id = :comment_id";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':statut', $comment['statut']);
    $stmt->bindParam(':archived', $comment['archived']);
    $stmt->bindParam(':comment_id', $commentId);

    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Commentaire mis à jour avec succès.'];
    } else {
        return ['success' => false, 'message' => 'Erreur lors de la mise à jour du commentaire.'];
    }
}