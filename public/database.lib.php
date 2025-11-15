<?php

function getDB(): PDO
{
    $pdo = new PDO("mysql:host=db;dbname=appdb", "appuser", "secret");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}

function getUserInfo(int $idUser): mixed
{

    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUser2FA(int $idUser): mixed
{
    $user = getUserInfo($idUser);
    if (empty($user['google2fa_secret'])) {
        return null;
    }
    return $user['google2fa_secret'];
}