<?php
session_start();

require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . '/../includes/config.php';
require_login($BASE);

$PAGE_TITLE = "Gioco • GameSAW";
$PAGE_CSS = "$BASE/public/assets/css/game.css";
require_once __DIR__ . "/../includes/header.php";
?>

<main class="layout">
  <section class="panel">
    <h1>Labirinto</h1>
    <p class="muted">Usa <b>WASD</b> o le <b>frecce</b>. Raggiungi <b>EXIT</b>.</p>

    <div class="stats">
      <div class="stat">
        <div class="stat-label">Tempo</div>
        <div class="stat-value" id="timer">00:00</div>
      </div>
      <div class="stat">
        <div class="stat-label">Mosse</div>
        <div class="stat-value" id="moves">0</div>
      </div>
      <div class="stat">
        <div class="stat-label">Punteggio</div>
        <div class="stat-value" id="score">—</div>
      </div>
    </div>

    <div class="controls">
      <button class="btn btn-primary" id="btnStart" type="button">Avvia</button>
      <button class="btn" id="btnReset" type="button">Reset</button>
    </div>

    <div class="difficulty">
      <label for="difficultySelect">Difficoltà</label>
      <select id="difficultySelect">
        <option value="easy" selected>Facile</option>
        <option value="medium">Media</option>
        <option value="hard">Difficile</option>
      </select>
    </div>

    <div class="message" id="message" aria-live="polite"></div>

    <form id="scoreForm" method="post" action="<?= $BASE ?>/public/api/save_score.php" class="hidden">
      <input type="hidden" name="score" id="scoreField" value="">
      <input type="hidden" name="moves" id="movesField" value="">
      <input type="hidden" name="time_sec" id="timeField" value="">
      <input type="hidden" name="difficulty" id="difficultyField" value="easy">
    </form>
  </section>

  <section class="game-area">
    <div class="game-card">
      <div class="game-header">
        <div class="game-title">Mappa</div>
        <div class="game-subtitle">Obiettivo: raggiungi EXIT</div>
      </div>

      <div id="maze" class="maze" role="grid" aria-label="Labirinto"></div>

      <div class="game-footer">
        <span class="pill">WASD / Frecce</span>
        <span class="pill">Start → movimento</span>
        <span class="pill">Reset → nuova partita</span>
      </div>
    </div>
  </section>
</main>

<script src="<?= $BASE ?>/public/assets/js/maze.js"></script>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
