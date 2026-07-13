<?php
session_start();

require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../includes/db.php";
require_once __DIR__ . '/../../includes/config.php';

require_login($BASE);

$uid = (int)$_SESSION["user_id"];

$score = isset($_POST["score"]) ? (int)$_POST["score"] : 0;
$moves = isset($_POST["moves"]) ? (int)$_POST["moves"] : null;
$time  = isset($_POST["time_sec"]) ? (int)$_POST["time_sec"] : null;
$diff  = isset($_POST["difficulty"]) ? trim($_POST["difficulty"]) : null;

if ($score < 0) $score = 0;

try {
  $stmt = $pdo->prepare("
    INSERT INTO scores (user_id, score, moves, time_sec, difficulty)
    VALUES (:uid, :score, :moves, :time_sec, :diff)
  ");
  $stmt->execute([
    ":uid" => $uid,
    ":score" => $score,
    ":moves" => $moves,
    ":time_sec" => $time,
    ":diff" => $diff
  ]);

  header("Location: $BASE/public/leaderboard.php");
  exit;

} catch (Exception $e) {
  header("Location: $BASE/public/game.php");
  exit;
}
