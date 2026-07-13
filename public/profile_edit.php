<?php
session_start();

require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/function.php";
require_once __DIR__ . '/../includes/config.php';
require_login($BASE);

$uid = (int)$_SESSION["user_id"];

$stmt = $pdo->prepare("
  SELECT u.nome, u.cognome, p.citta, p.about, p.website, p.social, p.level
  FROM users u
  LEFT JOIN profiles p ON p.user_id = u.id
  WHERE u.id = :id
  LIMIT 1
");
$stmt->execute([":id" => $uid]);
$row = $stmt->fetch();

$err = $_GET["err"] ?? "";
$ok  = $_GET["ok"] ?? "";

$PAGE_TITLE = "Modifica Profilo • GameSAW";
$PAGE_CSS = "$BASE/public/assets/css/auth.css";
require_once __DIR__ . "/../includes/header.php";
?>

<div class="wrap">
  <div class="card">
    <h1>Modifica profilo</h1>
    <p>I campi sono precompilati con i dati presenti nel database.</p>

    <?php if ($ok): ?><div class="msg ok">Profilo aggiornato!</div><?php endif; ?>
    <?php if ($err): ?><div class="msg err">Errore aggiornamento profilo.</div><?php endif; ?>

    <form method="post" action="<?= $BASE ?>/public/api/profile_update.php">
      <div class="grid">
        <div>
          <label>Nome *</label>
          <input name="nome" required maxlength="60" value="<?= h($row["nome"] ?? "") ?>">
        </div>
        <div>
          <label>Cognome *</label>
          <input name="cognome" required maxlength="60" value="<?= h($row["cognome"] ?? "") ?>">
        </div>

        <div>
          <label>Città</label>
          <input name="citta" maxlength="120" value="<?= h($row["citta"] ?? "") ?>">
        </div>
        <div>
          <label>Livello</label>
          <select name="level">
            <?php
              $levels = ["", "Beginner", "Intermediate", "Expert"];
              $cur = $row["level"] ?? "";
              foreach ($levels as $lv) {
                $sel = ($lv === $cur) ? "selected" : "";
                echo "<option value=\"" . h($lv) . "\" $sel>" . ($lv === "" ? "—" : h($lv)) . "</option>";
              }
            ?>
          </select>
        </div>
      </div>

      <label style="margin-top:12px;">About</label>
      <textarea name="about"><?= h($row["about"] ?? "") ?></textarea>

      <div class="grid" style="margin-top:12px;">
        <div>
          <label>Website</label>
          <input name="website" maxlength="255" value="<?= h($row["website"] ?? "") ?>" placeholder="https://...">
        </div>
        <div>
          <label>Social</label>
          <input name="social" maxlength="255" value="<?= h($row["social"] ?? "") ?>" placeholder="https://...">
        </div>
      </div>

      <div class="btns">
        <button class="btn btn-primary" type="submit">Salva</button>
        <a class="btn" href="<?= $BASE ?>/public/profile.php">Annulla</a>
      </div>
    </form>
  </div>
</div>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
