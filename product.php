<?php
$page_title = "Product detail";
require_once __DIR__ . '/core/bootstrap.php';

$id = (int)get('id');
$st = db()->prepare("SELECT * FROM products WHERE id=? AND is_active=1 LIMIT 1");
$st->execute([$id]);
$p = $st->fetch();

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';
?>

<main class="container my-4">
  <?php if (!$p): ?>
    <div class="card p-4">Không tìm thấy sản phẩm.</div>
  <?php else:
    $final = $p['sale_price'] ?? $p['price'];
  ?>
    <div class="row g-4">
      <div class="col-md-5">
        <img src="/<?= e($p['thumbnail'] ?: 'uploads/placeholder.png') ?>"
             class="w-100 rounded">
      </div>

      <div class="col-md-7">
        <h1 class="h4"><?= e($p['name']) ?></h1>
        <div class="fw-bold fs-5 my-2"><?= money($final) ?></div>

        <p class="text-muted"><?= nl2br(e($p['description'] ?? '')) ?></p>

        <form method="post" action="/cart_add.php" class="d-flex gap-2">
          <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
          <input type="number" name="qty" value="1" min="1" class="form-control" style="max-width:120px">
          <button class="btn btn-primary">Add to cart</button>
        </form>
      </div>
    </div>
  <?php endif; ?>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
