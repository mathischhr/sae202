<?php

require_once dirname(__DIR__, 2) . "/conf/conf.inc.php";

function getUsers() {
    global $dbInstance;

    $query = "SELECT * FROM users ORDER BY username ASC";
    $stmt = $dbInstance->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserById($id) {
    global $dbInstance;

    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
    unset($user['password']); // Remove password for security
    unset($user['admin_invitation_token']); // Remove admin invitation token if exists
    }
    return $user;
}

function createUser($username, $password, $email) {
    global $dbInstance;

    $query = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);

    return $stmt->execute();
}

function updateUser($id, $username, $email) {
    global $dbInstance;

    $query = "UPDATE users SET username = :username, email = :email WHERE id = :id";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);

    return $stmt->execute();
}

function deleteUser($id) {
    global $dbInstance;

    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $dbInstance->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
}

function countUsers() {
    global $dbInstance;

    $query = "SELECT COUNT(*) FROM users";
    $stmt = $dbInstance->prepare($query);
    $stmt->execute();

    return $stmt->fetchColumn();
}
