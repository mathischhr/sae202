<?php
require_once $GLOBALS['conf_dir'] . "conf.inc.php";
require_once $GLOBALS['model_dir'] . "user_model.php";
require_once $GLOBALS['model_dir'] . "event_model.php";


function getUserReservations(int $userId): array
{
    global $dbInstance;

    // Récupérer les réservations de l'utilisateur
    $query = "SELECT * FROM reservations WHERE user_id = :user_id ORDER BY date_reservation DESC";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function getReservationDetails(int $reservationId): ?array
{
    global $dbInstance;

    // Récupérer les détails d'une réservation
    $query = "SELECT * FROM reservations WHERE id = :reservation_id";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':reservation_id', $reservationId);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    return null;
}


function deleteReservation(int $reservationId): bool
{
    global $dbInstance;

    // Annuler une réservation
    $query = "DELETE FROM reservations WHERE id = :reservation_id";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':reservation_id', $reservationId);

    return $stmt->execute();
}


function createReservation(int $userId, array $data): ?array
{
    global $dbInstance;

    // Vérifier si l'utilisateur existe
    if (!userExists($userId)) {
        return ['success' => false, 'message' => 'Utilisateur non trouvé.'];
    }

    // vérifier si l'événement existe
    if (!isset($data['event_id']) || empty($data['event_id'])) {
        return ['success' => false, 'message' => 'ID de l\'événement manquant.'];
    }

    if (!getEventById($data['event_id'])) {
        return ['success' => false, 'message' => 'Événement non trouvé.'];
    }

    // Créer une nouvelle réservation
    $query = "INSERT INTO reservations (user_id, date_reservation, is_group, is_confirmed, event_id, nb_places) VALUES (:user_id, :date_reservation, :is_group, :is_confirmed, :event_id, :nb_places)";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':date_reservation', $data['date_reservation']);
    $stmt->bindParam(':is_group', $data['is_group']);
    $stmt->bindParam(':is_confirmed', 0); // Par défaut, la réservation n'est pas confirmée
    $stmt->bindParam(':event_id', $data['event_id']);
    $stmt->bindParam(':nb_places', $data['nb_places']);

   if ($stmt->execute()) {
        $reservationId = $dbInstance->lastInsertId();
        return ['success' => true, 'message' => 'Réservation créée avec succès.', 'reservation_id' => $reservationId];
    } else {
        return ['success' => false, 'message' => 'Erreur lors de la création de la réservation.'];
    }
}

function updateReservation(int $reservationId, array $data): ?array
{
    global $dbInstance;

    // Vérifier si la réservation existe
    $reservation = getReservationDetails($reservationId);
    if (!$reservation) {
        return ['success' => false, 'message' => 'Réservation non trouvée.'];
    }

    // Mettre à jour la réservation
    $query = "UPDATE reservations SET date_reservation = :date_reservation, is_group = :is_group, is_confirmed = :is_confirmed, event_id = :event_id, nb_places = :nb_places WHERE id = :reservation_id";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindParam(':date_reservation', $data['date_reservation']);
    $stmt->bindParam(':is_group', $data['is_group']);
    $stmt->bindParam(':is_confirmed', $data['is_confirmed']);
    $stmt->bindParam(':event_id', $data['event_id']);
    $stmt->bindParam(':nb_places', $data['nb_places']);
    $stmt->bindParam(':reservation_id', $reservationId);

    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Réservation mise à jour avec succès.'];
    } else {
        return ['success' => false, 'message' => 'Erreur lors de la mise à jour de la réservation.'];
    }
}