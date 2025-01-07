<?php

declare(strict_types=1);

function get_username(object $pdo, string $username) {
    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_email(object $pdo, string $email) {
    $query = "SELECT email FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo, string $gender, string $username, string $email, string $firstName, string $lastName, string $pwd) {
    $query = "INSERT INTO users (gender, firstName, lastName, username, email, pwd) VALUES (:gender, :firstName, :lastName, :username, :email, :pwd);";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];
    $hashedpwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":firstName", $firstName);
    $stmt->bindParam(":lastName", $lastName);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pwd", $hashedpwd);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
?>