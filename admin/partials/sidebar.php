<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '';

function nav_active(string $needle, string $path): string {
  // PHP 7.x safe
  return (strpos($path, $needle) !== false) ? 'style="background:#f4f5f7;opacity:1;"' : '';
}
?>
<aside class="admin-sidebar">
  <div class="admin-brand">
    <span class="dot"></span>
    <div>
      <div>ADMIN</div>
      <div style="font-size:12px;color:#6c757d;font-weight:700;">SimpleShop</div>
    </div>
  </div>

  <nav class="admin-nav d-grid gap-1">
    <a <?= nav_active('/admin/index.php',$path) ?> href="/admin/index.php">Dashboard</a>
    <a <?= nav_active('/admin/products',$path) ?> href="/admin/products.php">Products</a>
    <a <?= nav_active('/admin/categories',$path) ?> href="/admin/categories.php">Categories</a>
    <a <?= nav_active('/admin/orders',$path) ?> href="/admin/orders.php">Orders</a>
    <a <?= nav_active('/admin/users',$path) ?> href="/admin/users.php">Users</a>

    <hr class="my-3">
    <a href="/index.php">← Back to site</a>
  </nav>

  <div class="mt-auto pt-3" style="position:absolute;bottom:18px;left:18px;right:18px;">
    <div class="text-muted" style="font-size:12px;">
      Logged in as <b><?= e(($admin['full_name'] ?? 'Admin')) ?></b>
    </div>
    <a class="btn btn-outline-dark btn-sm w-100 mt-2 btn-ceo" href="/logout.php">Logout</a>
  </div>
</aside>
