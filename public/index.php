<?php
    // start session and unset the login session info
    session_start();
    unset($_SESSION['logged_in']);
    unset($_SESSION['user_id']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ad Cyber Safety &amp; Security - Startpage</title>
</head>
<body>

</body>
</html>
<h2>Login</h2>
<form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Gebruikersnaam" required><br>
    <input type="password" name="password" placeholder="Wachtwoord" required><br>
    <button type="submit">Login</button>
</form>
