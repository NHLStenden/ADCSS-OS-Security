<?php
require './database.lib.php';

session_start();
if (!($_SESSION['logged_in'] ?? false)) {
    header("Location: index.php");
    exit;
}
$username = $_SESSION['username'];
if ($username === 'admin') {
    $userToClearToken = $_GET['user'];
    $pdo = getDB();
    $stmt = $pdo->prepare("UPDATE users SET google2fa_enabled = 0, google2fa_secret = NULL WHERE username = ?");
    $stmt->execute([$userToClearToken]);
    header("Location: dashboard.php");

}