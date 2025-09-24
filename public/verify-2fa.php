<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use PragmaRX\Google2FA\Google2FA;

if (!isset($_SESSION['2fa_secret'])) {
    die("Geen 2FA secret gevonden. Log opnieuw in.");
}

$google2fa = new Google2FA();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'] ?? '';
    if ($google2fa->verifyKey($_SESSION['2fa_secret'], $code, 2)) {
        $_SESSION['logged_in'] = true;
        unset($_SESSION['2fa_secret']);
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Ongeldige code";
    }
}
?>

<h2>2FA Verificatie</h2>
<form method="POST">
    <input type="text" name="code" placeholder="2FA code" required>
    <button type="submit">Verifiëren</button>
</form>
