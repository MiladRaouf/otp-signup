<?php

function isUserExists(string $email): bool
{
    global $pdo;

    $sql = 'SELECT id FROM users WHERE email = :email;';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $records = $stmt->fetch(PDO::FETCH_OBJ);

    return $records ? true : false;
}

function createUser(array $userData): bool
{
    global $pdo;

    $sql = 'INSERT INTO users (name, email, mobile) VALUES (:name, :email, :mobile);';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => $userData['name'], ':email' => $userData['email'], ':mobile' => $userData['phone']]);

    return $stmt->rowCount() ? true : false;
}

function generateToken(): array
{
    global $pdo;

    $token = rand(111111, 999999);
    $hash = bin2hex(random_bytes(8));
    $expired_at = time() + 600;

    $sql = 'INSERT INTO tokens (hash, token, expired_at) VALUES (:hash, :token, :expired_at);';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':hash' => $hash, ':token' => $token, ':expired_at' => date("Y-m-d H:i:s", $expired_at)]);
    return [
        "hash" => $hash,
        "token" => $token
    ];
}

function findTokenByHash(string $hash): bool|object
{
    global $pdo;
    $sql = 'SELECT * FROM tokens WHERE hash = :hash;';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':hash' => $hash]);
    return $stmt->rowCount() ? $stmt->fetch(PDO::FETCH_OBJ) : false;
}

function isAliveToken(string $hash): bool
{
    $record = findTokenByHash($hash);
    if (!$record) return false;

    return strtotime($record->expired_at) > time() + 120;
}

function sendTokenByEmail(string $email, int|string $token): void
{
    global $mail;
    $mail->addAddress($email, 'hello');
    $mail->Subject = 'token for login';
    $mail->Body = 'token for login: ' . $token;
    $mail->send();
}

function issetToken(int $token, string $hash): bool
{
    global $pdo;

    $sql = 'SELECT * FROM tokens WHERE token=:token AND hash=:hash;';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':token' => $token, ':hash' => $hash]);
    $record = $stmt->fetch(PDO::FETCH_OBJ);

    return !$record ? false : true;
}

function chengeLoginSession(string $session, string $email): bool
{
    global $pdo;

    $sql = 'UPDATE users SET session = :session WHERE email = :email;';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":session" => $session, ":email" => $email]);

    return $stmt->rowCount() ? true : false;
}

function deleteExpiredToken(): bool
{
    global $pdo;

    $sql = 'DELETE FROM tokens WHERE expired_at < now();';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->rowCount() ? true : false;
}
