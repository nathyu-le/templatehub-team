<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
  $id = (int)($_POST['id'] ?? 0);
  if ($id > 0) {
    $st = db()->prepare("DELETE FROM products WHERE id=? LIMIT 1");
    $st->execute([$id]);
  }
  header("Location: /admin/products.php"); exit;
}

$rows = db()->query("
  SELECT p.*, c.name AS category_name
  FROM products p
  LEFT JOIN categories c ON c.id = p.category_id
  ORDER BY p.id DESC
")->fetchAll();
?>
<div class="admin-content">
  <div class="admin-topbar d-flex justify-content-between align-items-center">
    <div>
      <div style="font-weight:900;font-size:18px;">Products</div>
      <div class="text-muted" style="font-size:12px;">Manage inventory & pricing</div>
    </div>
    <a class="btn btn-dark btn-sm btn-ceo" href="/admin/product_form.php">+ Add Product</a>
  </div>

  <div class="cardx mt-3 p-3">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th style="width:70px;">ID</th>
            <th style="width:86px;">Image</th>
            <th>Name</th>
            <th>Category</th>
            <th style="width:140px;">Price</th>
            <th style="width:100px;">Stock</th>
            <th style="width:110px;">Active</th>
            <th style="width:180px;" class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($rows as $p): $thumb = $p['thumbnail'] ?: 'uploads/placeholder.png'; ?>
            <tr>
              <td><?= (int)$p['id'] ?></td>
              <td><img src="/<?= e($thumb) ?>" style="width:64px;height:64px;object-fit:cover;border-radius:14px;border:1px solid #eee;"></td>
              <td>
                <div class="fw-semibold"><?= e($p['name']) ?></div>
                <div class="text-muted" style="font-size:12px;"><?= e($p['slug']) ?></div>
              </td>
              <td><?= e($p['category_name'] ?? '-') ?></td>
              <td>
                <?= number_format((float)$p['price']) ?> ₫
                <?php if($p['sale_price'] !== null): ?>
                  <div class="text-muted" style="font-size:12px;">Sale: <?= number_format((float)$p['sale_price']) ?> ₫</div>
                <?php endif; ?>
              </td>
              <td><?= (int)$p['stock'] ?></td>
              <td>
                <?php if((int)$p['is_active'] === 1): ?>
                  <span class="pill ok">Active</span>
                <?php else: ?>
                  <span class="pill no">Off</span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <a class="btn btn-outline-dark btn-sm btn-ceo" href="/admin/product_form.php?id=<?= (int)$p['id'] ?>">Edit</a>
                <form method="post" class="d-inline" onsubmit="return confirm('Delete product?');">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                  <button class="btn btn-outline-danger btn-sm btn-ceo">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if(!$rows): ?>
            <tr><td colspan="8" class="text-center text-muted py-4">No products</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
