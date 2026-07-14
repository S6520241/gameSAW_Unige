<?php
session_start();
require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . '/../includes/config.php';
require_login($BASE);

$PAGE_TITLE = "Dashboard • GameSAW";
$PAGE_CSS = "$BASE/public/assets/css/game.css";

require_once __DIR__ . "/../includes/header.php";

?>

<main class="layout" style="grid-template-columns:1fr;">
  <section class="panel">
    <h1>Dashboard</h1>
    <p class="muted">Ciao <?= htmlspecialchars($_SESSION["user_nome"] ?? "") ?>! Scegli un opzione.</p>

    <div class="controls">
      <a class="btn btn-primary" href="<?= $BASE ?>/public/game.php">Gioca</a>
      <a class="btn" href="<?= $BASE ?>/public/profile.php">Profilo</a>
      <a class="btn" href="<?= $BASE ?>/public/leaderboard.php">Classifica</a>
      <a class="btn" href="<?= $BASE ?>/public/rate_game.php">Valuta il gioco</a>
    </div>
  </section>
</main>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>

