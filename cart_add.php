<?php
require_once __DIR__ . '/core/bootstrap.php';
require_login();

$productId = (int)post('product_id', 0);
$qty = (int)post('qty', 1);

if ($productId > 0) {
  cart_add((int)current_user()['id'], $productId, $qty);
}
redirect('/cart.php');
