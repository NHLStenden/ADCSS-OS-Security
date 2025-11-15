<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
require './database.lib.php';

use PragmaRX\Google2FA\Google2FA;

if (!isset($_SESSION['user_id'])) {
    die("Je moet ingelogd zijn.");
}
$idUser = $_SESSION['user_id'];

$google2fa = new Google2FA();
$error = '';
$secret = getUser2FA($idUser);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'] ?? '';
    if ($google2fa->verifyKey($secret, $code, 2)) {
        $_SESSION['logged_in'] = true;
        unset($_SESSION['2fa_secret']);
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "<h2 class='error'>Ongeldige code</h2>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify 2FA</title>
</head>
<body>

</body>
</html>
<h2>2FA Verificatie</h2>
<?= $error ?>
<form method="POST">
    <input type="text" name="code" placeholder="2FA code" required>
    <button type="submit">Verifiëren</button>
</form>
