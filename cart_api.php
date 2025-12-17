<?php
require_once __DIR__ . '/core/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$user = current_user();
if (!$user) {
  echo json_encode(['ok'=>false,'message'=>'Bạn cần đăng nhập.','redirect'=>'/login.php']);
  exit;
}

$userId = (int)$user['id'];
$action = $_POST['action'] ?? '';
$cartItemId = (int)($_POST['cart_item_id'] ?? 0);

if ($cartItemId <= 0) {
  echo json_encode(['ok'=>false,'message'=>'Thiếu cart_item_id']);
  exit;
}

if ($action === 'update') {
  $qty = (int)($_POST['quantity'] ?? 1);
  cart_update_qty($userId, $cartItemId, max(1,$qty));
} elseif ($action === 'remove') {
  cart_remove_item($userId, $cartItemId);
} else {
  echo json_encode(['ok'=>false,'message'=>'Action không hợp lệ']);
  exit;
}

$items = cart_get_items($userId);
$subtotal = 0;
$line_total_text = null;
foreach ($items as $it) {
  $subtotal += (float)$it['line_total'];
  if ((int)$it['cart_item_id'] === $cartItemId) {
    $line_total_text = money($it['line_total']);
  }
}

echo json_encode([
  'ok'=>true,
  'message'=>'OK',
  'count'=>cart_count_items_by_user($userId),
  'subtotal'=>$subtotal,
  'subtotal_text'=>money($subtotal),
  'line_total_text'=>$line_total_text
]);
