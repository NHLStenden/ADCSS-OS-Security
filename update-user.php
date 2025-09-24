<?php

use PragmaRX\Google2FA\Google2FA;

require __DIR__ . '/vendor/autoload.php';

// Database connectie
$pdo = new PDO("mysql:host=db;dbname=appdb", "appuser", "secret");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Instellingen
$username = 'admin';         // gebruiker die je wilt updaten
$newPassword = 'wachtwoord'; // nieuw wachtwoord
$reset2FA = true;            // true = nieuwe 2FA secret genereren

// Nieuwe bcrypt-hash van het wachtwoord
$passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

// Update query
$updateFields = "password_hash = :password_hash";
$params = [':password_hash' => $passwordHash];

/*
 * Please note: better to encrypt the generated key using some other key (e.g. from an environment var)
 */

if ($reset2FA) {
    $google2fa = new Google2FA();
    $newSecret = $google2fa->generateSecretKey();
    $updateFields .= ", google2fa_secret = :google2fa_secret, google2fa_enabled = 1";
    $params[':google2fa_secret'] = $newSecret;
}

$params[':username'] = $username;

$stmt = $pdo->prepare("UPDATE users SET $updateFields WHERE username = :username");
$stmt->execute($params);

echo "Gebruiker '$username' is bijgewerkt.\n";

if ($reset2FA) {
    echo "Nieuwe 2FA secret: $newSecret\n";
    echo "Scan deze in Google Authenticator.\n";
}
