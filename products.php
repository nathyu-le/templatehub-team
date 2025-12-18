<?php
// products.php
$page_title = "Products";
require_once __DIR__ . '/core/bootstrap.php';

$q    = trim($_GET['q'] ?? '');
$cat  = (int)($_GET['cat'] ?? 0);

// categories
$cats = db()->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();

// build SQL
$where = "WHERE p.is_active = 1";
$params = [];

if ($q !== '') {
  $where .= " AND p.name LIKE ?";
  $params[] = "%$q%";
}
if ($cat > 0) {
  $where .= " AND p.category_id = ?";
  $params[] = $cat;
}

$sql = "
  SELECT p.*
  FROM products p
  $where
  ORDER BY p.created_at DESC
";

$st = db()->prepare($sql);
$st->execute($params);
$products = $st->fetchAll();

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';
?>

<main class="container my-4">

  <div class="d-flex justify-content-between align-items-end mb-3">
    <div>
      <h1 class="h4 mb-1">Products</h1>
      <div class="text-muted" style="font-size:13px;">
        Browse all available products
      </div>
    </div>
  </div>

  <!-- FILTER -->
  <form class="row g-2 mb-3" method="get">
    <div class="col-md-5">
      <input
        class="form-control"
        name="q"
        value="<?= e($q) ?>"
        placeholder="Search products..."
      >
    </div>

    <div class="col-md-4">
      <select class="form-select" name="cat">
        <option value="0">All categories</option>
        <?php foreach ($cats as $c): ?>
          <option value="<?= (int)$c['id'] ?>" <?= $cat===(int)$c['id']?'selected':'' ?>>
            <?= e($c['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-3 d-grid">
      <button class="btn btn-dark">Filter</button>
    </div>
  </form>

  <!-- PRODUCTS GRID -->
  <?php if (!$products): ?>
    <div class="border rounded-4 p-4 bg-white text-muted">
      No products found.
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($products as $p):
$price = (float)$p['price'];
$sale  = ($p['sale_price'] === null) ? null : (float)$p['sale_price'];

$final = $price;
if ($sale !== null && $sale > 0 && $sale < $price) {
  $final = $sale;
}
        $thumb = $p['thumbnail'] ?: 'uploads/placeholder.png';
      ?>
        <div class="col-6 col-md-3">
          <?php require __DIR__ . '/partials/product_item.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
