<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header("Location:/admin/orders.php"); exit; }

$st = db()->prepare("SELECT * FROM orders WHERE id=? LIMIT 1");
$st->execute([$id]);
$order = $st->fetch();
if (!$order) { header("Location:/admin/orders.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $order_status = $_POST['order_status'] ?? 'pending';
  $payment_status = $_POST['payment_status'] ?? 'unpaid';
  if (!in_array($order_status, ['pending','confirmed','shipping','done','cancelled'], true)) $order_status='pending';
  if (!in_array($payment_status, ['unpaid','paid'], true)) $payment_status='unpaid';

  $up = db()->prepare("UPDATE orders SET order_status=?, payment_status=? WHERE id=? LIMIT 1");
  $up->execute([$order_status, $payment_status, $id]);

  header("Location:/admin/order_view.php?id=".$id); exit;
}

$items = db()->prepare("SELECT * FROM order_items WHERE order_id=? ORDER BY id ASC");
$items->execute([$id]);
$items = $items->fetchAll();
?>
<div class="admin-content">
  <div class="admin-topbar d-flex justify-content-between align-items-center">
    <div>
      <div style="font-weight:900;font-size:18px;">Order #<?= (int)$order['id'] ?> — <?= e($order['order_code']) ?></div>
      <div class="text-muted" style="font-size:12px;">Customer: <?= e($order['full_name']) ?> • <?= e($order['phone']) ?></div>
    </div>
    <a class="btn btn-outline-dark btn-sm btn-ceo" href="/admin/orders.php">Back</a>
  </div>

  <div class="row g-3 mt-1">
    <div class="col-md-5">
      <div class="cardx p-3">
        <div class="fw-bold mb-2">Shipping</div>
        <div class="text-muted" style="font-size:12px;">Address</div>
        <div class="fw-semibold"><?= e($order['address']) ?></div>
        <?php if(!empty($order['note'])): ?>
          <div class="mt-2 text-muted" style="font-size:12px;">Note</div>
          <div><?= e($order['note']) ?></div>
        <?php endif; ?>

        <hr>
        <form method="post" class="d-grid gap-2">
          <div>
            <label class="form-label">Order status</label>
            <select class="form-select" name="order_status">
              <?php foreach(['pending','confirmed','shipping','done','cancelled'] as $s): ?>
                <option value="<?= $s ?>" <?= ($order['order_status']===$s)?'selected':'' ?>><?= $s ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label class="form-label">Payment status</label>
            <select class="form-select" name="payment_status">
              <?php foreach(['unpaid','paid'] as $s): ?>
                <option value="<?= $s ?>" <?= ($order['payment_status']===$s)?'selected':'' ?>><?= $s ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <button class="btn btn-dark btn-ceo">Update</button>
        </form>
      </div>
    </div>

    <div class="col-md-7">
      <div class="cardx p-3">
        <div class="d-flex justify-content-between">
          <div class="fw-bold">Items</div>
          <div class="fw-bold"><?= number_format((float)$order['total']) ?> ₫</div>
        </div>
        <div class="table-responsive mt-2">
          <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Product</th><th class="text-end">Unit</th><th class="text-end">Qty</th><th class="text-end">Line</th></tr></thead>
            <tbody>
              <?php foreach($items as $it): ?>
                <tr>
                  <td class="fw-semibold"><?= e($it['product_name']) ?></td>
                  <td class="text-end"><?= number_format((float)$it['unit_price']) ?> ₫</td>
                  <td class="text-end"><?= (int)$it['quantity'] ?></td>
                  <td class="text-end"><?= number_format((float)$it['line_total']) ?> ₫</td>
                </tr>
              <?php endforeach; ?>
              <?php if(!$items): ?>
                <tr><td colspan="4" class="text-center text-muted py-3">No items</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <hr class="my-3">
        <div class="d-flex justify-content-between text-muted" style="font-size:13px;">
          <div>Subtotal</div><div><?= number_format((float)$order['subtotal']) ?> ₫</div>
        </div>
        <div class="d-flex justify-content-between text-muted" style="font-size:13px;">
          <div>Shipping</div><div><?= number_format((float)$order['shipping_fee']) ?> ₫</div>
        </div>
        <div class="d-flex justify-content-between text-muted" style="font-size:13px;">
          <div>Discount</div><div><?= number_format((float)$order['discount']) ?> ₫</div>
        </div>
        <div class="d-flex justify-content-between fw-bold mt-2">
          <div>Total</div><div><?= number_format((float)$order['total']) ?> ₫</div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
