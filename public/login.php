<?php
session_start();
require_once __DIR__ . '/../includes/config.php';

// Se l'utente è già loggato lo mando in dashboard
if (isset($_SESSION["user_id"])) {
  header("Location: $BASE/public/dashboard.php");
  exit;
}

// Messaggi errore/successo
$err = isset($_GET["err"]) ? $_GET["err"] : "";
$ok  = isset($_GET["ok"]) ? $_GET["ok"] : "";
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login • GameSAW</title>

  <link rel="stylesheet" href="<?= $BASE ?>/public/assets/css/auth.css">

</head>

<body>
  <div class="wrap">
    <div class="top">
      <a href="<?= $BASE ?>/public/index.php">← Home</a>
      <a href="<?= $BASE ?>/public/register.php">Non hai un account? Registrati</a>
    </div>

    <div class="card">
      <h1>Accedi</h1>
      <p>Inserisci email e password per entrare nell’area riservata.</p>

      <?php if ($ok): ?>
        <div class="msg ok">
          <?php
            $mapOk = [
              "registered" => "Registrazione completata! Ora puoi fare login.",
              "logout" => "Logout effettuato con successo."
            ];
            echo htmlspecialchars($mapOk[$ok] ?? "Operazione completata.");
          ?>
        </div>
      <?php endif; ?>

      <?php if ($err): ?>
        <div class="msg err">
          <?php
            $mapErr = [
              "missing" => "Inserisci email e password.",
              "invalid" => "Credenziali non valide.",
              "server" => "Errore del server. Riprova."
            ];
            echo htmlspecialchars($mapErr[$err] ?? "Errore. Riprova.");
          ?>
        </div>
      <?php endif; ?>

      <form method="post" action="<?= $BASE ?>/public/api/login_action.php" autocomplete="on">
        <div class="row">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" required maxlength="255"
                 placeholder="nome@example.com"
                 value="<?= isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '' ?>">
        </div>

        <div class="row">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" required placeholder="••••••••">
        </div>

        <div class="btns">
          <button class="btn btn-primary" type="submit">Login</button>
          <a class="btn" href="<?= $BASE ?>/public/register.php">Crea account</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
