<?php
session_start();

require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../includes/db.php";
require_once __DIR__ . '/../../includes/config.php';

require_login($BASE);

$uid = (int)$_SESSION["user_id"];

$cur = $_POST["current_password"] ?? "";
$new1 = $_POST["new_password"] ?? "";
$new2 = $_POST["new_password2"] ?? "";

if ($cur === "" || $new1 === "" || $new2 === "") {
  header("Location: $BASE/public/password_change.php?err=missing");
  exit;
}
if ($new1 !== $new2) {
  header("Location: $BASE/public/password_change.php?err=mismatch");
  exit;
}
if (strlen($new1) < 6) {
  header("Location: $BASE/public/password_change.php?err=short");
  exit;
}

try {
  $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id=:id LIMIT 1");
  $stmt->execute([":id"=>$uid]);
  $row = $stmt->fetch();

  if (!$row || empty($row["password_hash"]) || !password_verify($cur, $row["password_hash"])) {
    header("Location: $BASE/public/password_change.php?err=wrong");
    exit;
  }

  $hash = password_hash($new1, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare("UPDATE users SET password_hash=:h WHERE id=:id");
  $stmt->execute([":h"=>$hash, ":id"=>$uid]);

  header("Location: $BASE/public/password_change.php?ok=1");
  exit;

} catch (Exception $e) {
  header("Location: $BASE/public/password_change.php?err=server");
  exit;
}
