<?php
// core/cart.php
require_once __DIR__ . '/db.php';

function get_or_create_active_cart_id(int $userId): int {
  $pdo = db();

  // active cart is the one with cart_status='active' AND is_active=1
  $st = $pdo->prepare("SELECT id FROM carts WHERE user_id=? AND cart_status='active' AND is_active=1 LIMIT 1");
  $st->execute([$userId]);
  $row = $st->fetch();
  if ($row) return (int)$row['id'];

  // create one active cart
  $st = $pdo->prepare("INSERT INTO carts(user_id, cart_status, is_active) VALUES(?, 'active', 1)");
  $st->execute([$userId]);
  return (int)$pdo->lastInsertId();
}

function cart_count_items_by_user(int $userId): int {
  $pdo = db();
  $st = $pdo->prepare("
    SELECT COALESCE(SUM(ci.quantity),0) AS c
    FROM carts c
    LEFT JOIN cart_items ci ON ci.cart_id=c.id
    WHERE c.user_id=? AND c.cart_status='active' AND c.is_active=1
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
    ON DUPLICATE KEY UPDATE
      quantity = quantity + VALUES(quantity),
      unit_price = VALUES(unit_price)
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
  return $st->fetchAll() ?: [];
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

  try {
    $cartId = get_or_create_active_cart_id($userId);

    // load items (same connection)
    $st = $pdo->prepare("
      SELECT
        ci.product_id,
        ci.quantity,
        ci.unit_price,
        (ci.quantity * ci.unit_price) AS line_total,
        p.name
      FROM cart_items ci
      JOIN products p ON p.id = ci.product_id
      WHERE ci.cart_id=?
      ORDER BY ci.id DESC
    ");
    $st->execute([$cartId]);
    $items = $st->fetchAll();

    if (!$items) {
      $pdo->rollBack();
      return 0;
    }

    $full_name = trim($ship['full_name'] ?? '');
    $phone     = trim($ship['phone'] ?? '');
    $address   = trim($ship['address'] ?? '');
    $note      = $ship['note'] ?? null;
    $pmethod   = $ship['payment_method'] ?? 'cod';

    if ($full_name === '' || $phone === '' || $address === '') {
      $pdo->rollBack();
      return 0;
    }

    $subtotal = 0.0;
    foreach ($items as $it) $subtotal += (float)$it['line_total'];
    $shipping_fee = 0.0;
    $discount = 0.0;
    $total = $subtotal + $shipping_fee - $discount;

    $order_code = 'OD' . date('Ymd') . '-' . str_pad((string)random_int(1, 9999), 4, '0', STR_PAD_LEFT);

    // create order
    $st = $pdo->prepare("
      INSERT INTO orders(
        user_id, cart_id, order_code,
        full_name, phone, address, note,
        subtotal, shipping_fee, discount, total,
        payment_method, payment_status, order_status
      ) VALUES(
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'unpaid', 'pending'
      )
    ");
    $st->execute([
      $userId, $cartId, $order_code,
      $full_name, $phone, $address, $note,
      $subtotal, $shipping_fee, $discount, $total,
      $pmethod
    ]);
    $orderId = (int)$pdo->lastInsertId();

    // order items snapshot
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

    // IMPORTANT: ordered carts must NOT keep is_active=1 (set NULL)
    $st = $pdo->prepare("UPDATE carts SET cart_status='ordered', is_active=NULL WHERE id=? AND user_id=?");
    $st->execute([$cartId, $userId]);

    // create new active cart
    $st = $pdo->prepare("INSERT INTO carts(user_id, cart_status, is_active) VALUES(?, 'active', 1)");
    $st->execute([$userId]);

    $pdo->commit();
    return $orderId;

  } catch (Throwable $e) {
    $pdo->rollBack();
    throw $e;
  }
}
