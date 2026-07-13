<?php
session_start();

require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . '/../includes/config.php';

require_login($BASE);

require_once __DIR__ . "/../includes/function.php";

$uid = (int)$_SESSION["user_id"];

// Controllo se l'utente ha giocato almeno una volta
$stmt = $pdo->prepare("SELECT COUNT(*) AS n FROM scores WHERE user_id = :id");
$stmt->execute([":id" => $uid]);
$hasPlayed = ((int)$stmt->fetch()["n"] > 0);

//Media rating
$avgStmt = $pdo->query("SELECT AVG(rating) AS avg_rating, COUNT(*) AS cnt FROM game_ratings");
$avgRow = $avgStmt->fetch();
$avg = $avgRow["avg_rating"] !== null ? round((float)$avgRow["avg_rating"], 2) : null;
$cnt = (int)$avgRow["cnt"];

// Rating dell'utente
$userRating = null;
$uStmt = $pdo->prepare("SELECT rating FROM game_ratings WHERE user_id = :id LIMIT 1");
$uStmt->execute([":id" => $uid]);
$uRow = $uStmt->fetch();
if ($uRow) $userRating = (int)$uRow["rating"];

$err = $_GET["err"] ?? "";
$ok = $_GET["ok"] ?? "";
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Valuta il gioco • GameSAW</title>
  <link rel="stylesheet" href="<?= $BASE ?>/public/assets/css/auth.css">

  <style>
    .stars{ display:flex; flex-direction:row-reverse; gap:8px; justify-content:flex-end; }
    .stars input{ display:none; }
    .stars label{
      cursor:pointer; font-size:28px; line-height:1;
      filter: drop-shadow(0 6px 12px rgba(0,0,0,.25));
      opacity:.55; transition: opacity .15s ease, transform .08s ease;
      user-select:none;
    }
    .stars label:hover{ opacity:1; transform: scale(1.05); }
    .stars input:checked ~ label{ opacity:1; }
    .metric{ margin-top:12px; }
    .metric b{ font-size:18px; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="top">
      <a href="<?= $BASE ?>/public/dashboard.php">← Dashboard</a>
      <a href="<?= $BASE ?>/public/leaderboard.php">Classifica</a>
    </div>

    <div class="card">
      <h1>Valuta il gioco</h1>
      <p>Lascia una valutazione da 1 a 5 stelle. Puoi aggiornare il voto quando vuoi.</p>

      <?php if ($ok): ?>
        <div class="msg ok">Valutazione salvata! Grazie 😄</div>
      <?php endif; ?>

      <?php if ($err): ?>
        <div class="msg err">
          <?php
            $map = [
              "not_played" => "Puoi valutare solo dopo aver giocato almeno una volta.",
              "invalid" => "Valutazione non valida (scegli da 1 a 5).",
              "server" => "Errore del server. Riprova."
            ];
            echo htmlspecialchars($map[$err] ?? "Errore.");
          ?>
        </div>
      <?php endif; ?>

      <div class="msg metric">
        <div><b>Media attuale:</b> <?= $avg === null ? "—" : htmlspecialchars((string)$avg) ?>/5</div>
        <div><b>Numero voti:</b> <?= htmlspecialchars((string)$cnt) ?></div>
      </div>

      <?php if (!$hasPlayed): ?>
        <div class="msg err">
          Non hai ancora giocato: completa almeno una partita per poter lasciare una valutazione.
        </div>
        <div class="btns">
          <a class="btn btn-primary" href="<?= $BASE ?>/public/game.php">Gioca ora</a>
        </div>
      <?php else: ?>
        <form method="post" action="<?= $BASE ?>/public/api/rate_action.php">
          <label>La tua valutazione</label>

          <div class="stars" aria-label="Valutazione a stelle">
            <?php for ($i=5; $i>=1; $i--): ?>
              <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" <?= ($userRating === $i) ? "checked" : "" ?>>
              <label for="star<?= $i ?>" title="<?= $i ?> stelle">★</label>
            <?php endfor; ?>
          </div>

          <div class="small" style="margin-top:8px;">
            <?= $userRating ? "Il tuo voto attuale è: <b>" . htmlspecialchars((string)$userRating) . "/5</b>" : "Non hai ancora votato." ?>
          </div>

          <div class="btns">
            <button class="btn btn-primary" type="submit">Salva valutazione</button>
            <a class="btn" href="<?= $BASE ?>/public/game.php">Gioca</a>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
