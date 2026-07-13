<?php
require_once __DIR__ . '/../includes/config.php';
session_start();

// Se l'utente è già loggato lo mando in dashboard
if (isset($_SESSION["user_id"])) {
  header("Location: $BASE/public/dashboard.php");
  exit;
}

// Messaggi di errore/successo
$err = isset($_GET["err"]) ? $_GET["err"] : "";
$ok  = isset($_GET["ok"]) ? $_GET["ok"] : "";

?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrazione • GameSAW</title>

  <link rel="stylesheet" href="<?= $BASE ?>/public/assets/css/auth.css">
</head>

<body>
  <div class="wrap">
    <div class="top">
      <a href="<?= $BASE ?>/public/index.php">← Home</a>
      <a href="<?= $BASE ?>/public/login.php">Hai già un account? Login</a>
    </div>

    <div class="card">
      <h1>Crea il tuo account</h1>
      <p>Inserisci email, nome, cognome e una password (ripetuta due volte).</p>

      <?php if ($err): ?>
        <div class="msg err">
          <?php
            $map = [
              "missing" => "Compila tutti i campi richiesti.",
              "email" => "Email non valida.",
              "pwd_mismatch" => "Le password non coincidono.",
              "pwd_short" => "Password troppo corta (minimo 8 caratteri consigliato).",
              "email_taken" => "Registrazione fallita, controlla le credenziali inserite",
              "server" => "Errore del server. Riprova."
            ];
            echo htmlspecialchars($map[$err] ?? "Errore. Riprova.");
          ?>
        </div>
      <?php endif; ?>

      <?php if ($ok): ?>
        <div class="msg ok">Registrazione completata! Ora puoi fare login.</div>
      <?php endif; ?>

      <form method="post" action="<?= $BASE ?>/public/api/register_action.php" autocomplete="on">
        <div class="grid">
          <div>
            <label for="email">Email *</label>
            <input id="email" name="email" type="email" required maxlength="255" placeholder="nome@example.com"
                   value="<?= isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '' ?>">
          </div>

          <div>
            <label for="nome">Nome *</label>
            <input id="nome" name="nome" type="text" required maxlength="60" placeholder="Mario"
                   value="<?= isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : '' ?>">
          </div>

          <div>
            <label for="cognome">Cognome *</label>
            <input id="cognome" name="cognome" type="text" required maxlength="60" placeholder="Rossi"
                   value="<?= isset($_GET['cognome']) ? htmlspecialchars($_GET['cognome']) : '' ?>">
          </div>

          <div></div>

          <div>
            <label for="password">Password *</label>
            <input id="password" name="password" type="password" required minlength="8" placeholder="••••••••">
          </div>

          <div>
            <label for="password2">Ripeti password *</label>
            <input id="password2" name="password2" type="password" required minlength="8" placeholder="••••••••">
          </div>
        </div>

        <div class="btns">
          <button class="btn btn-primary" type="submit">Registrati</button>
          <a class="btn" href="<?= $BASE ?>/public/login.php">Vai al Login</a>
        </div>

      </form>
    </div>
  </div>
</body>
</html>
