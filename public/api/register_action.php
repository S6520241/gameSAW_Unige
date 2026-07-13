<?php
session_start();

require_once __DIR__ . "/../../includes/db.php";
require_once __DIR__ . '/../../includes/config.php';


$email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$nome = isset($_POST["nome"]) ? trim($_POST["nome"]) : "";
$cognome = isset($_POST["cognome"]) ? trim($_POST["cognome"]) : "";
$password = $_POST["password"] ?? "";
$password2 = $_POST["password2"] ?? "";

if ($email === "" || $nome === "" || $cognome === "" || $password === "" || $password2 === "") {
  header("Location: $BASE/public/register.php?err=missing");
  exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header("Location: $BASE/public/register.php?err=email&email=" . urlencode($email));
  exit;
}
if ($password !== $password2) {
  header("Location: $BASE/public/register.php?err=pwd_mismatch&email=" . urlencode($email));
  exit;
}
if (strlen($password) < 6) {
  header("Location: $BASE/public/register.php?err=pwd_short&email=" . urlencode($email));
  exit;
}

try {
  $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
  $stmt->execute([":email" => $email]);
  if ($stmt->fetch()) {
    header("Location: $BASE/public/register.php?err=email_taken&email=" . urlencode($email));
    exit;
  }

  $hash = password_hash($password, PASSWORD_DEFAULT);

  $pdo->beginTransaction();

  $stmt = $pdo->prepare("INSERT INTO users (email, password_hash, nome, cognome) VALUES (:email, :hash, :nome, :cognome)");
  $stmt->execute([
    ":email" => $email,
    ":hash" => $hash,
    ":nome" => $nome,
    ":cognome" => $cognome
  ]);
  $userId = (int)$pdo->lastInsertId();

  $stmt = $pdo->prepare("INSERT INTO profiles (user_id) VALUES (:uid)");
  $stmt->execute([":uid" => $userId]);

  $pdo->commit();

  header("Location: $BASE/public/login.php?ok=registered&email=" . urlencode($email));
  exit;

} catch (Exception $e) {
  
  if ($pdo->inTransaction()) $pdo->rollBack();
  header("Location: $BASE/public/register.php?err=server");
  exit;
}
