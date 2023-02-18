<?php

function isUserExists(int $mobile, string $email): bool
{
    global $pdo;

    $sql = 'SELECT id FROM users WHERE mobile = :mobile OR email = :email;';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':mobile' => $mobile, ':email' => $email]);
    $records = $stmt->fetch(PDO::FETCH_OBJ);

    return $records ? true : false;
}

function createUser(array $userData): bool
{
    // die();
    global $pdo;
    
    $sql = 'INSERT INTO users (name, email, mobile) VALUES (:name, :email, :mobile);';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => $userData['name'], ':email' => $userData['email'], ':mobile' => $userData['phone']]);

    return $stmt->rowCount() ? true : false;
}
