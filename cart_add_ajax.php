<?php
require_once __DIR__ . '/core/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$user = current_user();
if (!$user) {
  echo json_encode(['ok'=>false,'message'=>'Bạn cần đăng nhập.','redirect'=>'/login.php']);
  exit;
}

$productId = (int)($_POST['product_id'] ?? 0);
$qty = (int)($_POST['qty'] ?? 1);

if ($productId <= 0) {
  echo json_encode(['ok'=>false,'message'=>'Thiếu product_id']);
  exit;
}

cart_add((int)$user['id'], $productId, max(1,$qty));
$count = cart_count_items_by_user((int)$user['id']);

echo json_encode(['ok'=>true,'message'=>'Đã thêm vào giỏ.','count'=>$count]);
