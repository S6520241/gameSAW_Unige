<?php
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . '/../includes/config.php';

$avgStmt = $pdo->query("SELECT AVG(rating) AS avg_rating, COUNT(*) AS cnt FROM game_ratings");
$avgRow = $avgStmt->fetch();
$avg = $avgRow["avg_rating"] !== null ? round((float)$avgRow["avg_rating"], 2) : null;
$cnt = (int)$avgRow["cnt"];
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GameSAW - Mini Labirinto</title>

  <link rel="stylesheet" href="<?= $BASE ?>/public/assets/css/home.css" />
</head>

<body>
  <header class="topbar">
    <div class="brand">
      <div class="logo">🧩</div>
      <div>
        <div class="brand-title">GameSAW</div>
        <div class="brand-subtitle">Mini Labirinto</div>
      </div>
    </div>

    <nav class="nav">
      <a href="<?= $BASE ?>/public/index.php" class="nav-link is-active">Home</a>
      <a href="<?= $BASE ?>/public/leaderboard.php" class="nav-link">Classifica</a>
      <a href="<?= $BASE ?>/public/login.php" class="btn btn-ghost">Login</a>
      <a href="<?= $BASE ?>/public/register.php" class="btn btn-primary">Registrati</a>
    </nav>
  </header>

  <main class="container">
    <section class="hero">
      <div class="hero-left">
        <div class="badge">🎮 Gioco online • SAW</div>
        <h1>Scappa dal labirinto.</h1>
        <p class="subtitle">
          Muoviti con <b>WASD</b> o le <b>frecce</b>, evita i muri e raggiungi l’uscita.
          Più sei veloce, più punti fai!
        </p>

        <div class="hero-actions">
          <a class="btn btn-primary btn-big" href="<?= $BASE ?>/public/game.php">Gioca ora</a>
          <a class="btn btn-ghost btn-big" href="<?= $BASE ?>/public/leaderboard.php">Vedi classifica</a>
        </div>

        <div class="mini-info">
          <div class="info-card">
            <div class="info-title">Obiettivo</div>
            <div class="info-text">Arriva alla casella <b>EXIT</b> nel minor tempo possibile.</div>
          </div>
          <div class="info-card">
            <div class="info-title">Punteggio</div>
            <div class="info-text">Calcolato da <b>tempo</b> e <b>mosse</b>.</div>
          </div>
          <div class="info-card">
            <div class="info-title">Profilo</div>
            <div class="info-text">Personalizza città, bio e livello giocatore.</div>
          </div>
        </div>
      </div>

      <div class="hero-right">
        <div class="preview">
          <div class="preview-top">
            <span class="dot red"></span>
            <span class="dot yellow"></span>
            <span class="dot green"></span>
          </div>

          <div class="mini-maze" aria-hidden="true">
            <div class="cell wall"></div><div class="cell wall"></div><div class="cell wall"></div><div class="cell wall"></div><div class="cell wall"></div><div class="cell wall"></div><div class="cell wall"></div>
            <div class="cell wall"></div><div class="cell start player"></div><div class="cell path"></div><div class="cell wall"></div><div class="cell path"></div><div class="cell path"></div><div class="cell wall"></div>
            <div class="cell wall"></div><div class="cell path"></div><div class="cell path"></div><div class="cell wall"></div><div class="cell path"></div><div class="cell wall"></div><div class="cell wall"></div>
            <div class="cell wall"></div><div class="cell wall"></div><div class="cell path"></div><div class="cell path"></div><div class="cell path"></div><div class="cell path"></div><div class="cell wall"></div>
            <div class="cell wall"></div><div class="cell path"></div><div class="cell wall"></div><div class="cell wall"></div><div class="cell wall"></div><div class="cell path"></div><div class="cell wall"></div>
            <div class="cell wall"></div><div class="cell path"></div><div class="cell path"></div><div class="cell path"></div><div class="cell wall"></div><div class="cell exit"></div><div class="cell wall"></div>
            <div class="cell wall"></div><div class="cell wall"></div><div class="cell wall"></div><div class="cell wall"></div><div class="cell wall"></div><div class="cell wall"></div><div class="cell wall"></div>
          </div>

          <div class="preview-footer">
            <span class="pill">WASD / Frecce</span>
            <span class="pill">Tempo & Mosse</span>
            <span class="pill">Top-10</span>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <h2>Come funziona</h2>
      <div class="grid-3">
        <article class="card">
          <h3>1) Registrati</h3>
          <p>
            Crea un account con email e password. Il profilo è modificabile in qualsiasi momento.
          </p>
        </article>

        <article class="card">
          <h3>2) Gioca</h3>
          <p>
            Ogni partita misura tempo e mosse. Quando raggiungi EXIT, il punteggio viene salvato.
          </p>
        </article>

        <article class="card">
          <h3>3) Scala la classifica</h3>
          <p>
            La classifica mostra i migliori giocatori. Punta al Top-10!
          </p>
        </article>
      </div>
    </section>

    <section class="section">
      <div class="cta">
        <div class="cta-text">
          <h2>Pronto a scappare?</h2>
          <p class="subtitle">
            Accedi e prova a migliorare il tuo record. Più giochi, più sali in classifica.
          </p>
        </div>
        <div class="cta-actions">
          <a class="btn btn-primary btn-big" href="<?= $BASE ?>/public/register.php">Crea account</a>
          <a class="btn btn-ghost btn-big" href="<?= $BASE ?>/public/login.php">Ho già un account</a>
        </div>
      </div>

      <div class="pill">Valutazione: <?= $avg === null ? "—" : $avg ?>/5 (<?= $cnt ?>)</div>
    </section>
  </main>

  <footer class="footer">
    <div class="footer-inner">
      <div class="footer-left">
        <div class="brand-footer">
          <span class="logo">🧩</span>
          <span>GameSAW • Sviluppo di Applicazioni Web</span>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
