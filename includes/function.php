<?php

function h(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function redirect(string $url): void {
  header("Location: " . $url);
  exit;
}
