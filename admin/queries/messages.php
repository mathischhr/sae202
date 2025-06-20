<?php

require_once dirname(__DIR__, 2) . "/conf/conf.inc.php";
require_once "users.php";


function getMessages()
{
    global $dbInstance;

    $query = "SELECT * FROM messages ORDER BY date_envoi DESC";
    $stmt = $dbInstance->prepare($query);
    $stmt->execute();

    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $d = [];
    foreach ($messages as $message) {
        $message['date'] = date('d/m/Y H:i', strtotime($message['date_envoi']));
        $message['contenu'] = htmlspecialchars($message['contenu'], ENT_QUOTES, 'UTF-8');
       
            $user = getUserById($message['user_id']);
            $message['author'] = $user['username'];
            $message['email'] = $user['email'];
            $message['role'] = $user['role'];
        $d[] = $message;
    }

  
    return $d;
}

function countMessages()
{
    global $dbInstance;

    $query = "SELECT COUNT(*) AS total FROM messages";
    $stmt = $dbInstance->prepare($query);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total'] ?? 0;
}