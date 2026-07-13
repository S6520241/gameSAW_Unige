<?php
session_start();

require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . '/../includes/config.php';
require_login($BASE);

$err = $_GET["err"] ?? "";
$ok  = $_GET["ok"] ?? "";

$PAGE_TITLE = "Cambia Password • GameSAW";
$PAGE_CSS = "$BASE/public/assets/css/auth.css";
require_once __DIR__ . "/../includes/header.php";
?>

<div class="wrap">
  <div class="card">
    <h1>Cambia password</h1>
    <p>Per sicurezza, la password si modifica separatamente dal profilo.</p>

    <?php if ($ok): ?><div class="msg ok">Password aggiornata!</div><?php endif; ?>
    <?php if ($err): ?>
      <div class="msg err">
        <?php
          $map = [
            "missing" => "Compila tutti i campi.",
            "wrong" => "Password attuale errata.",
            "mismatch" => "Le nuove password non coincidono.",
            "short" => "Password troppo corta.",
            "server" => "Errore del server."
          ];
          echo htmlspecialchars($map[$err] ?? "Errore.");
        ?>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= $BASE ?>/public/api/password_update.php">
      <label>Password attuale</label>
      <input type="password" name="current_password" required>

      <div class="grid" style="margin-top:12px;">
        <div>
          <label>Nuova password</label>
          <input type="password" name="new_password" required minlength="6">
        </div>
        <div>
          <label>Ripeti nuova password</label>
          <input type="password" name="new_password2" required minlength="6">
        </div>
      </div>

      <div class="btns">
        <button class="btn btn-primary" type="submit">Aggiorna</button>
        <a class="btn" href="<?= $BASE ?>/public/profile.php">Torna al profilo</a>
      </div>
    </form>
  </div>
</div>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
