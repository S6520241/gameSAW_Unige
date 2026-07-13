<?php
session_start();

require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/function.php";
require_once __DIR__ . '/../includes/config.php';

$stmt = $pdo->query("
  SELECT u.nome, u.cognome, MAX(s.score) AS best_score
  FROM users u
  JOIN scores s ON s.user_id = u.id
  GROUP BY u.id
  ORDER BY best_score DESC
  LIMIT 10
");
$top = $stmt->fetchAll();

$PAGE_TITLE = "Classifica • GameSAW";
$PAGE_CSS = "$BASE/public/assets/css/game.css";
require_once __DIR__ . "/../includes/header.php";
?>

<main class="layout" style="grid-template-columns:1fr;">
  <section class="panel">
    <h1>Classifica Top-10</h1>
    <p class="muted">Mostra il miglior punteggio di ogni utente.</p>

    <div style="overflow:auto; margin-top:12px;">
      <table style="width:100%; border-collapse:collapse;">
        <thead>
          <tr>
            <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,.12);">#</th>
            <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,.12);">Giocatore</th>
            <th style="text-align:left; padding:10px; border-bottom:1px solid rgba(255,255,255,.12);">Best score</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$top): ?>
            <tr><td colspan="3" style="padding:10px;" class="muted">Nessun punteggio ancora. Gioca una partita!</td></tr>
          <?php else: ?>
            <?php foreach ($top as $i => $r): ?>
              <tr>
                <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,.06);"><?= $i+1 ?></td>
                <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,.06);">
                  <?= h($r["nome"]) ?> <?= h($r["cognome"]) ?>
                </td>
                <td style="padding:10px; border-bottom:1px solid rgba(255,255,255,.06); font-weight:900;">
                  <?= h((string)$r["best_score"]) ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="controls" style="margin-top:14px;">
      <a class="btn btn-primary" href="<?= $BASE ?>/public/game.php">Gioca</a>
      <?php if (!isset($_SESSION["user_id"])): ?>
        <a class="btn" href="<?= $BASE ?>/public/login.php">Login</a>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
