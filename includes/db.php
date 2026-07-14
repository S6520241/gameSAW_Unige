<?php

$DB_HOST = "localhost";
$DB_NAME = "s6520241";
$DB_USER = "s6520241";
$DB_PASS = "francesco123";
$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";

$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
];

try {
  $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    die("Errore connessione DB: " . $e->getMessage());
}
