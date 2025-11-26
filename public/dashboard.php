<?php
require './database.lib.php';

session_start();
if (!($_SESSION['logged_in'] ?? false)) {
    header("Location: index.php");
    exit;
}

?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Dashboard</title>
        <style>
            body {
                font-family: sans-serif;
            }
            span.mfa {
                display: inline-block;
                padding: 3px;
                background: darkgray;
                color: white;
                font-weight: bold;
                width: 4rem;
                border-radius: 4px;
                  }
        </style>
    </head>
    <body>
<h2>Welkom op je dashboard!</h2>
<p>Je bent ingelogd met 2FA</p>
<a href="index.php">Uitloggen</a>
<?php
  $username = $_SESSION['username'];
  if ($username === 'admin') {
      echo "<h3>Clear 2fa token for users:</h3>";

      $pdo = getDB();
      $stmt = $pdo->prepare("SELECT * FROM users WHERE username <> 'admin' ORDER BY username ");
      $stmt->execute([]);
      $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo "<ul>";
      foreach ($users as $value) {
          $username = $value['username'];
          $has2fa = ($value['google2fa_enabled'] === 1);
          if ($has2fa) {
              $indicator = $has2fa ? "<span class='mfa'>2fa</span>" : "";
              $href =  "cleartoken.php?user=$username";
              $link = "<a href='$href' >" . $username . "</a>";

              echo "<li>$link $indicator </li>";
          }
          else {
              echo "<li>$username </li>";
          }
      }
      echo "</ul>";

  }

?>
    </body>
</html>

