<?php
// core/cart.php
require_once _DIR_ . '/db.php';

function get_or_create_active_cart_id(int $userId): int {
  $pdo = db();

  $st = $pdo->prepare("SELECT id FROM carts WHERE user_id=? AND is_active=1 LIMIT 1");
  $st->execute([$userId]);
  if ($row = $st->fetch()) return (int)$row['id'];

  $st = $pdo->prepare("INSERT INTO carts(user_id, status, is_active) VALUES(?, 'active', 1)");
  $st->execute([$userId]);
  return (int)$pdo->lastInsertId();
}

function cart_count_items_by_user(int $userId): int {
  $pdo = db();
  $st = $pdo->prepare("
    SELECT COALESCE(SUM(ci.quantity),0) AS c
    FROM carts c
    LEFT JOIN cart_items ci ON ci.cart_id=c.id
    WHERE c.user_id=? AND c.is_active=1
  ");
  $st->execute([$userId]);
  return (int)($st->fetch()['c'] ?? 0);
}

function cart_add(int $userId, int $productId, int $qty = 1): void {
  $qty = max(1, $qty);
  $pdo = db();
  $cartId = get_or_create_active_cart_id($userId);

  $st = $pdo->prepare("SELECT id, price, sale_price, is_active FROM products WHERE id=? LIMIT 1");
  $st->execute([$productId]);
  $p = $st->fetch();
  if (!$p || (int)$p['is_active'] !== 1) return;

  $unit = ($p['sale_price'] !== null) ? (float)$p['sale_price'] : (float)$p['price'];

  $st = $pdo->prepare("
    INSERT INTO cart_items(cart_id, product_id, quantity, unit_price)
    VALUES(?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)
  ");
  $st->execute([$cartId, $productId, $qty, $unit]);
}

function cart_get_items(int $userId): array {
  $pdo = db();
  $cartId = get_or_create_active_cart_id($userId);

  $st = $pdo->prepare("
    SELECT
      ci.id AS cart_item_id,
      ci.product_id,
      ci.quantity,
      ci.unit_price,
      (ci.quantity * ci.unit_price) AS line_total,
      p.name, p.thumbnail
    FROM cart_items ci
    JOIN products p ON p.id = ci.product_id
    WHERE ci.cart_id=?
    ORDER BY ci.id DESC
  ");
  $st->execute([$cartId]);
  return $st->fetchAll();
}

function cart_update_qty(int $userId, int $cartItemId, int $qty): void {
  $qty = max(1, $qty);
  $pdo = db();
  $cartId = get_or_create_active_cart_id($userId);

  $st = $pdo->prepare("UPDATE cart_items SET quantity=? WHERE id=? AND cart_id=?");
  $st->execute([$qty, $cartItemId, $cartId]);
}

function cart_remove_item(int $userId, int $cartItemId): void {
  $pdo = db();
  $cartId = get_or_create_active_cart_id($userId);

  $st = $pdo->prepare("DELETE FROM cart_items WHERE id=? AND cart_id=?");
  $st->execute([$cartItemId, $cartId]);
}

function cart_checkout(int $userId, array $ship): int {
  $pdo = db();
  $pdo->beginTransaction();

  $cartId = get_or_create_active_cart_id($userId);

  $items = cart_get_items($userId);
  if (!$items) {
    $pdo->rollBack();
    return 0;
  }

  $subtotal = 0;
  foreach ($items as $it) $subtotal += (float)$it['line_total'];
  $shipping_fee = 0;
  $discount = 0;
  $total = $subtotal + $shipping_fee - $discount;

  $order_code = 'OD' . date('Ymd') . '-' . str_pad((string)random_int(1, 9999), 4, '0', STR_PAD_LEFT);

  $st = $pdo->prepare("
    INSERT INTO orders(user_id, cart_id, order_code, full_name, phone, address, note,
                       subtotal, shipping_fee, discount, total, payment_method)
    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  ");
  $st->execute([
    $userId, $cartId, $order_code,
    $ship['full_name'], $ship['phone'], $ship['address'], $ship['note'] ?? null,
    $subtotal, $shipping_fee, $discount, $total, $ship['payment_method'] ?? 'cod'
  ]);
  $orderId = (int)$pdo->lastInsertId();

  $stItem = $pdo->prepare("
    INSERT INTO order_items(order_id, product_id, product_name, unit_price, quantity, line_total)
    VALUES(?, ?, ?, ?, ?, ?)
  ");
  foreach ($items as $it) {
    $stItem->execute([
      $orderId,
      (int)$it['product_id'],
      $it['name'],
      (float)$it['unit_price'],
      (int)$it['quantity'],
      (float)$it['line_total'],
    ]);
  }

  // cart cũ -> ordered, bỏ active
  $st = $pdo->prepare("UPDATE carts SET status='ordered', is_active=NULL WHERE id=? AND user_id=?");
  $st->execute([$cartId, $userId]);

  // tạo cart active mới
  $st = $pdo->prepare("INSERT INTO carts(user_id, status, is_active) VALUES(?, 'active', 1)");
  $st->execute([$userId]);

  $pdo->commit();
  return $orderId;
}