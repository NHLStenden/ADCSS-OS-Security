<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

if (!isset($_SESSION['user_id'])) {
    die("Je moet ingelogd zijn.");
}

$pdo = new PDO("mysql:host=db;dbname=appdb", "appuser", "secret");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$google2fa = new Google2FA();

if (empty($user['google2fa_secret'])) {
    $secret = $google2fa->generateSecretKey();
    $stmt = $pdo->prepare("UPDATE users SET google2fa_secret = ?, google2fa_enabled = 1 WHERE id = ?");
    $stmt->execute([$secret, $user['id']]);
} else {
    $secret = $user['google2fa_secret'];
}

$qrText = $google2fa->getQRCodeUrl('MijnApp', $user['username'], $secret);

$renderer = new ImageRenderer(new RendererStyle(200), new SvgImageBackEnd());
$writer = new Writer($renderer);
$qrCode = $writer->writeString($qrText);

echo "<h2>Scan deze QR-code in Google Authenticator</h2>";
echo "<img src='data:image/svg+xml;base64," . base64_encode($qrCode) . "' />";
echo "<p>Secret: $secret</p>";
