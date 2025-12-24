<?php
// core/bootstrap.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/cart.php';
function blog_image($path) {
    if (!$path) return '/uploads/placeholder.png'; // fallback khi DB trống
    return '/' . ltrim($path, '/'); // đảm bảo luôn có dấu /
}
