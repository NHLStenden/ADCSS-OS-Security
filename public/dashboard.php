<?php
session_start();
if (!($_SESSION['logged_in'] ?? false)) {
    header("Location: index.php");
    exit;
}
?>
<h2>Welkom op je dashboard!</h2>
<p>Je bent ingelogd met 2FA 🎉</p>
<a href="index.php">Uitloggen</a>
