<?php
session_start();

require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/function.php";
require_once __DIR__ . '/../includes/config.php';
require_login($BASE);

$uid = (int)$_SESSION["user_id"];

$stmt = $pdo->prepare("
  SELECT u.email, u.nome, u.cognome, p.citta, p.about, p.website, p.social, p.level
  FROM users u
  LEFT JOIN profiles p ON p.user_id = u.id
  WHERE u.id = :id
  LIMIT 1
");
$stmt->execute([":id" => $uid]);
$row = $stmt->fetch();

$stmt2 = $pdo->prepare("SELECT MAX(score) AS best_score, COUNT(*) AS plays FROM scores WHERE user_id = :id");
$stmt2->execute([":id" => $uid]);
$stats = $stmt2->fetch();

$PAGE_TITLE = "Profilo • GameSAW";
$PAGE_CSS = "$BASE/public/assets/css/auth.css";
require_once __DIR__ . "/../includes/header.php";
?>

<div class="wrap">
  <div class="card">
    <h1>Profilo</h1>
    <p>Qui vedi le informazioni salvate nel database.</p>

    <div class="msg">
      <b>Best score:</b> <?= h((string)($stats["best_score"] ?? "—")) ?> &nbsp; • &nbsp;
      <b>Partite:</b> <?= h((string)($stats["plays"] ?? "0")) ?>
    </div>

    <div class="grid" style="margin-top:12px;">
      <div>
        <label>Email</label>
        <input value="<?= h($row["email"] ?? "") ?>" disabled>
      </div>
      <div>
        <label>Nome</label>
        <input value="<?= h(($row["nome"] ?? "") . " " . ($row["cognome"] ?? "")) ?>" disabled>
      </div>
      <div>
        <label>Città</label>
        <input value="<?= h($row["citta"] ?? "") ?>" disabled>
      </div>
      <div>
        <label>Livello</label>
        <input value="<?= h($row["level"] ?? "") ?>" disabled>
      </div>
    </div>

    <label style="margin-top:12px;">About</label>
    <textarea disabled><?= h($row["about"] ?? "") ?></textarea>

    <div class="grid" style="margin-top:12px;">
      <div>
        <label>Website</label>
        <input value="<?= h($row["website"] ?? "") ?>" disabled>
      </div>
      <div>
        <label>Social</label>
        <input value="<?= h($row["social"] ?? "") ?>" disabled>
      </div>
    </div>

    <div class="btns">
      <a class="btn btn-primary" href="<?= $BASE ?>/public/profile_edit.php">Modifica profilo</a>
      <a class="btn" href="<?= $BASE ?>/public/password_change.php">Cambia password</a>
    </div>
  </div>
</div>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
