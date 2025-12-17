<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';

$status = trim($_GET['status'] ?? '');

$where = "";
$params = [];
if ($status !== '') { $where = "WHERE order_status=?"; $params[] = $status; }

$st = db()->prepare("
  SELECT id, order_code, full_name, phone, total, payment_method, payment_status, order_status, created_at
  FROM orders
  $where
  ORDER BY id DESC
  LIMIT 200
");
$st->execute($params);
$orders = $st->fetchAll();
?>
<div class="admin-content">
  <div class="admin-topbar d-flex justify-content-between align-items-center">
    <div>
      <div style="font-weight:900;font-size:18px;">Orders</div>
      <div class="text-muted" style="font-size:12px;">Review and update order statuses</div>
    </div>

    <form class="d-flex gap-2" method="get">
      <select class="form-select form-select-sm" name="status" style="width:180px;">
        <option value="">All statuses</option>
        <?php foreach(['pending','confirmed','shipping','done','cancelled'] as $s): ?>
          <option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= $s ?></option>
        <?php endforeach; ?>
      </select>
      <button class="btn btn-outline-dark btn-sm btn-ceo">Filter</button>
    </form>
  </div>

  <div class="cardx mt-3 p-3">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th>ID</th><th>Code</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Created</th><th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($orders as $o): ?>
            <tr>
              <td><?= (int)$o['id'] ?></td>
              <td class="fw-semibold"><?= e($o['order_code']) ?></td>
              <td>
                <div class="fw-semibold"><?= e($o['full_name']) ?></div>
                <div class="text-muted" style="font-size:12px;"><?= e($o['phone']) ?></div>
              </td>
              <td><?= number_format((float)$o['total']) ?> ₫</td>
              <td><?= e($o['payment_method']) ?> / <?= e($o['payment_status']) ?></td>
              <td><?= e($o['order_status']) ?></td>
              <td class="text-muted" style="font-size:12px;"><?= e($o['created_at']) ?></td>
              <td class="text-end">
                <a class="btn btn-outline-dark btn-sm btn-ceo" href="/admin/order_view.php?id=<?= (int)$o['id'] ?>">View</a>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if(!$orders): ?>
            <tr><td colspan="8" class="text-center text-muted py-4">No orders</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
