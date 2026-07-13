<?php
session_start();

require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../includes/db.php";
require_once __DIR__ . '/../../includes/config.php';

require_login($BASE);

$uid = (int)$_SESSION["user_id"];

$nome = trim($_POST["nome"] ?? "");
$cognome = trim($_POST["cognome"] ?? "");
$citta = trim($_POST["citta"] ?? "");
$about = trim($_POST["about"] ?? "");
$website = trim($_POST["website"] ?? "");
$social = trim($_POST["social"] ?? "");
$level = trim($_POST["level"] ?? "");

if ($nome === "" || $cognome === "") {
  header("Location: $BASE/public/profile_edit.php?err=1");
  exit;
}

try {
  $pdo->beginTransaction();

  $stmt = $pdo->prepare("UPDATE users SET nome = :n, cognome = :c WHERE id = :id");
  $stmt->execute([":n"=>$nome, ":c"=>$cognome, ":id"=>$uid]);

  $stmt = $pdo->prepare("
    UPDATE profiles
    SET citta=:citta, about=:about, website=:website, social=:social, level=:level
    WHERE user_id=:id
  ");
  $stmt->execute([
    ":citta"=>$citta ?: null,
    ":about"=>$about ?: null,
    ":website"=>$website ?: null,
    ":social"=>$social ?: null,
    ":level"=>$level ?: null,
    ":id"=>$uid
  ]);

  $pdo->commit();

  $_SESSION["user_nome"] = $nome;
  $_SESSION["user_cognome"] = $cognome;

  header("Location: $BASE/public/profile_edit.php?ok=1");
  exit;

} catch (Exception $e) {
  if ($pdo->inTransaction()) $pdo->rollBack();
  header("Location: $BASE/public/profile_edit.php?err=1");
  exit;
}
