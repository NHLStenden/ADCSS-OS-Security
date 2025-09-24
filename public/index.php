<?php session_start(); ?>
<h2>Login</h2>
<form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Gebruikersnaam" required><br>
    <input type="password" name="password" placeholder="Wachtwoord" required><br>
    <button type="submit">Login</button>
</form>
<a href="setup-2fa.php">2FA instellen</a>
