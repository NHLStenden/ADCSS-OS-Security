<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
require './database.lib.php';

$pdo = getDB();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('User not found');
}

$hash = $user['password_hash'];
$isGoogle2faEnabled = $user['google2fa_enabled'];
$idUser = $user['id'];

if ($user && password_verify($password, $hash)) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $idUser;
    $_SESSION['username'] = $username;

    if ($isGoogle2faEnabled) {
        header("Location: verify-2fa.php");
        exit;
    } else {
        header("Location: setup-2fa.php");
        exit;
    }
}

echo "Login mislukt";
