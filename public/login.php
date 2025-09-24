<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

$pdo = new PDO("mysql:host=db;dbname=appdb", "appuser", "secret");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];

    if ($user['google2fa_enabled']) {
        $_SESSION['2fa_secret'] = $user['google2fa_secret'];
        header("Location: verify-2fa.php");
        exit;
    }

    $_SESSION['logged_in'] = true;
    header("Location: dashboard.php");
    exit;
}

echo "Login mislukt";
