<?php
session_start();

require_once __DIR__ . "/../../includes/db.php";
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . '/../../includes/config.php';

require_login($BASE);

$uid = (int)$_SESSION["user_id"];
$rating = isset($_POST["rating"]) ? (int)$_POST["rating"] : 0;

if ($rating < 1 || $rating > 5) {
  header("Location: $BASE/public/rate_game.php?err=invalid");
  exit;
}

// Deve aver giocato almeno una volta
$stmt = $pdo->prepare("SELECT COUNT(*) AS n FROM scores WHERE user_id = :id");
$stmt->execute([":id" => $uid]);
if ((int)$stmt->fetch()["n"] <= 0) {
  header("Location: $BASE/public/rate_game.php?err=not_played");
  exit;
}

try {
  // Inserisci voto
  $stmt = $pdo->prepare("
    INSERT INTO game_ratings (user_id, rating)
    VALUES (:uid, :r)
    ON DUPLICATE KEY UPDATE rating = VALUES(rating)
  ");
  $stmt->execute([":uid" => $uid, ":r" => $rating]);

  header("Location: $BASE/public/rate_game.php?ok=1");
  exit;

} catch (Exception $e) {
  header("Location: $BASE/public/rate_game.php?err=server");
  exit;
}
