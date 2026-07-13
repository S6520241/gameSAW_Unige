<?php
session_start();

require_once __DIR__ . "/../../includes/db.php"; 
require_once __DIR__ . '/../../includes/config.php';


$email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";

if ($email === "" || $password === "") {
  header("Location: $BASE/public/login.php?err=missing&email=" . urlencode($email));
  exit;
}

// Cerca utente per email
try {
  $stmt = $pdo->prepare("SELECT id, email, password_hash, nome, cognome FROM users WHERE email = :email LIMIT 1");
  $stmt->execute([":email" => $email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // Email non trovata
  if (!$user) {
    header("Location: $BASE/public/login.php?err=invalid&email=" . urlencode($email));
    exit;
  }

  // Se password è NULL l'utente non puo fare login classico
  if (empty($user["password_hash"])) {
    header("Location: $BASE/public/login.php?err=invalid&email=" . urlencode($email));
    exit;
  }

  // 3) Verifica password
  if (!password_verify($password, $user["password_hash"])) {
    header("Location: $BASE/public/login.php?err=invalid&email=" . urlencode($email));
    exit;
  }

  // 4) Login OK
  session_regenerate_id(true);
  $_SESSION["user_id"] = (int)$user["id"];
  $_SESSION["user_email"] = $user["email"];
  $_SESSION["user_nome"] = $user["nome"];
  $_SESSION["user_cognome"] = $user["cognome"];

  header("Location: $BASE/public/dashboard.php");
  exit;

} catch (Exception $e) {
    header("Location: $BASE/public/login.php?err=server&email=" . urlencode($email));
    exit;
}
