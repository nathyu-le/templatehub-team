<?php
// core/helpers.php
function e(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): never {
  header("Location: " . $path);
  exit;
}

function money($n): string {
  return number_format((float)$n, 0, ',', '.') . "₫";
}

function post(string $key, $default = '') {
  return $_POST[$key] ?? $default;
}

function get(string $key, $default = '') {
  return $_GET[$key] ?? $default;
}