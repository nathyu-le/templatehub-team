<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';

$ordersTotal   = (int)db()->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$ordersDone    = (int)db()->query("SELECT COUNT(*) FROM orders WHERE order_status='done'")->fetchColumn();
$revenueDone   = (float)db()->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE order_status='done'")->fetchColumn();
$productsTotal = (int)db()->query("SELECT COUNT(*) FROM products")->fetchColumn();
$usersTotal    = (int)db()->query("SELECT COUNT(*) FROM users")->fetchColumn();

$recentOrders = db()->query("
  SELECT id, order_code, full_name, total, order_status, created_at
  FROM orders
  ORDER BY id DESC
  LIMIT 8
")->fetchAll();
?>
<div class="admin-content">
  <div class="admin-topbar d-flex justify-content-between align-items-center">
    <div>
      <div style="font-weight:900;font-size:18px;">Dashboard</div>
      <div class="text-muted" style="font-size:12px;">Overview of store performance</div>
    </div>
    <div class="d-flex gap-2">
      <a class="btn btn-dark btn-sm btn-ceo" href="/admin/orders.php">View Orders</a>
      <a class="btn btn-outline-dark btn-sm btn-ceo" href="/admin/product_form.php">Add Product</a>
    </div>
  </div>

  <div class="row g-3 mt-1">
    <div class="col-md-3"><div class="stat"><div class="k">Orders</div><div class="v"><?= $ordersTotal ?></div></div></div>
    <div class="col-md-3"><div class="stat"><div class="k">Done Orders</div><div class="v"><?= $ordersDone ?></div></div></div>
    <div class="col-md-3"><div class="stat"><div class="k">Revenue (Done)</div><div class="v"><?= number_format($revenueDone) ?> ₫</div></div></div>
    <div class="col-md-3"><div class="stat"><div class="k">Products</div><div class="v"><?= $productsTotal ?></div></div></div>
  </div>

  <div class="row g-3 mt-1">
    <div class="col-md-6"><div class="stat"><div class="k">Users</div><div class="v"><?= $usersTotal ?></div></div></div>
    <div class="col-md-6"><div class="stat"><div class="k">System</div><div class="v">OK</div></div></div>
  </div>

  <div class="cardx mt-3 p-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div style="font-weight:900;">Recent Orders</div>
      <a class="btn btn-outline-dark btn-sm btn-ceo" href="/admin/orders.php">All</a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th>ID</th><th>Code</th><th>Customer</th><th>Total</th><th>Status</th><th>Created</th><th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($recentOrders as $o): ?>
            <tr>
              <td><?= (int)$o['id'] ?></td>
              <td class="fw-semibold"><?= e($o['order_code']) ?></td>
              <td><?= e($o['full_name']) ?></td>
              <td><?= number_format((float)$o['total']) ?> ₫</td>
              <td><?= e($o['order_status']) ?></td>
              <td class="text-muted" style="font-size:12px;"><?= e($o['created_at']) ?></td>
              <td class="text-end">
                <a class="btn btn-outline-dark btn-sm btn-ceo" href="/admin/order_view.php?id=<?= (int)$o['id'] ?>">View</a>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if(!$recentOrders): ?>
            <tr><td colspan="7" class="text-center text-muted py-4">No orders</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
