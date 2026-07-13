<?php

function require_login(string $basePath): void {
  if (!isset($_SESSION["user_id"])) {
    header("Location: $basePath/public/login.php");
    exit;
  }
}
