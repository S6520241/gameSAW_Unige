<?php
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($PAGE_TITLE) ? htmlspecialchars($PAGE_TITLE) : "GameSAW" ?></title>
  <?php if (isset($PAGE_CSS)): ?>
    <link rel="stylesheet" href="<?= $PAGE_CSS ?>">
  <?php endif; ?>
</head>
<body>
<header class="topbar">
  <div class="brand">
    <span class="logo">🧩</span>
    <span class="title">GameSAW • Mini Labirinto</span>
  </div>
  <nav class="top-actions">
    <a class="link" href="<?= $BASE ?>/public/index.php">Home</a>
    <a class="link" href="<?= $BASE ?>/public/leaderboard.php">Classifica</a>
    <?php if (isset($_SESSION["user_id"])): ?>
      <a class="link" href="<?= $BASE ?>/public/dashboard.php">Dashboard</a>
      <a class="link" href="<?= $BASE ?>/public/profile.php">Profilo</a>
      <a class="btn btn-ghost" href="<?= $BASE ?>/public/logout.php">Logout</a>
    <?php else: ?>
      <a class="btn btn-ghost" href="<?= $BASE ?>/public/login.php">Login</a>
      <a class="btn btn-primary" href="<?= $BASE ?>/public/register.php">Registrati</a>
    <?php endif; ?>
  </nav>
</header>
