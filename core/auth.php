<?php
// core/auth.php
require_once _DIR_ . '/db.php';
require_once _DIR_ . '/helpers.php';

function ensure_session(): void {
  if (session_status() === PHP_SESSION_NONE) session_start();
}

function current_user(): ?array {
  ensure_session();
  if (empty($_SESSION['user_id'])) return null;

  $st = db()->prepare("SELECT id, full_name, email, role, status FROM users WHERE id=? LIMIT 1");
  $st->execute([$_SESSION['user_id']]);
  $u = $st->fetch();
  return $u ?: null;
}

function require_login(): void {
  ensure_session();
  if (empty($_SESSION['user_id'])) redirect('/login.php');
}

function require_admin(): void {
  $u = current_user();
  if (!$u || $u['role'] !== 'admin') redirect('/login.php');
}

function auth_login(int $userId): void {
  ensure_session();
  $_SESSION['user_id'] = $userId;
}

function auth_logout(): void {
  ensure_session();
  session_unset();
  session_destroy();
}