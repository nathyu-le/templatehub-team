<?php
$page_title = "Thành công";
require_once __DIR__ . '/core/bootstrap.php';
require_login();

$id = (int)get('id',0);
$st = db()->prepare("SELECT * FROM orders WHERE id=? AND user_id=? LIMIT 1");
$st->execute([$id, (int)current_user()['id']]);
$order = $st->fetch();

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';
?>

<main class="container my-4">
  <?php if (!$order): ?>
    <div class="card p-4">Không tìm thấy đơn.</div>
  <?php else: ?>
    <div class="card p-4">
      <h1 class="h4"><i class="fi fi-tr-shopping-basket"></i> Đặt hàng thành công</h1>
      <p class="text-muted">Mã đơn: <b><?= e($order['order_code']) ?></b></p>
      <p>Tổng tiền: <b><?= money($order['total']) ?></b></p>
      <a style="
  background: #ff7a00;
  color: #fff;
" class="btn btn-cta" href="/products.php">Mua tiếp</a>
    </div>
  <?php endif; ?>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
