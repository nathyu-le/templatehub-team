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
  $price = (float)$p['price'];
  $sale  = ($p['sale_price'] === null) ? null : (float)$p['sale_price'];
  $final = ($sale !== null && $sale > 0 && $sale < $price) ? $sale : $price;
?>

<div class="row g-4">

  <!-- IMAGE -->
  <div class="col-md-5">
    <img src="/<?= e($p['thumbnail'] ?: 'uploads/placeholder.png') ?>"
         class="w-100 product-image">
  </div>

  <!-- INFO -->
  <div class="col-md-7">

    <h1 class="h4 product-title mb-1"><?= e($p['name']) ?></h1>

    <div class="small text-muted mb-3"><img style="weight:40px; height:35px;" src="uploads/sale.png" alt"" >
      ProductCode: MS10293841<?= $p['id'] ?> ·
      <span class="text-success fw-semibold">In Stock</span> 
    </div>

    <!-- PRICE -->
    <div class="price-box rounded p-3 mb-3">
      <?php if ($sale !== null && $sale < $price): ?>
        <span class="badge bg-danger mb-2">Giảm giá</span>
        <div>
          <del class="text-muted"><?= money($price) ?></del>
          <span class="fs-4 fw-bold text-danger ms-2"><?= money($final) ?></span>
        </div>
      <?php else: ?>
        <div class="fs-4 fw-bold"><?= money($price) ?></div>
      <?php endif; ?>
      <div class="small text-muted mt-1">the price of the product includes VAT!</div>
    </div>
<!-- SIZE SELECT -->
<div class="mb-3">
  <div class="d-flex gap-2 size-selector">
    <button type="button" class="btn btn-outline-secondary size-btn" data-size="M">M</button>
    <button type="button" class="btn btn-outline-secondary size-btn" data-size="L">L</button>
    <button type="button" class="btn btn-outline-secondary size-btn" data-size="XL">XL</button>
    <button type="button" class="btn btn-outline-secondary size-btn" data-size="XXL">XXL</button>
  </div>
  <input type="hidden" name="size" id="selectedSize">
</div>

   <div class="mb-4">
  <h6 class="fw-muted mb-2">Size Chart (European Standard – EU)</h6>
  <div class="table-responsive">
    <table class="table table-bordered table-sm align-middle text-center">
      <thead class="table-light">
        <tr>
          <th>size</th>
          <th>wide(cm)</th>
          <th>waist(cm)</th>
          <th>shoulder(cm)</th>
          <th>long(cm)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>M</td>
          <td>96–100</td>
          <td>80–84</td>
          <td>44–45</td>
          <td>165–170</td>
        </tr>
        <tr>
          <td>L</td>
          <td>100–104</td>
          <td>84–88</td>
          <td>46–47</td>
          <td>170–175</td>
        </tr>
        <tr>
          <td>XL</td>
          <td>104–108</td>
          <td>88–92</td>
          <td>48–49</td>
          <td>175–180</td>
        </tr>
        <tr>
          <td>XXL</td>
          <td>108–112</td>
          <td>92–96</td>
          <td>50–51</td>
          <td>180–185</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="small text-muted">
   * The size chart is for reference only, with a margin of error of 1–2cm.
  </div>
</div>


    <!-- ADD TO CART -->
    <form method="post" action="/cart_add.php" class="d-flex gap-2 mb-3">
      <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
      <input type="number" name="qty" value="1" min="1"
             class="form-control" style="max-width:120px">
      <button class="btn btn-cta px-4 add-to-cart-btn">
        Add to cart
      </button>
    </form>
<style> .btn-cta {
  background: #ff7a00;
  color: #fff;
}
</style>
    <!-- POLICY -->
  <div class="policy-box rounded p-4 mt-4"> 
  <h6 class="fw-muted mb-2"><img style="weight:40px; height:35px;" src="uploads/NOTE.png" alt"" ></h6>
  <ul class="list-unstyled mb-0 policy-list">
    <li>
      <span><strong>·</strong> Local delivery within 2-4 hours, Free returns within 7 days</span>
    </li>


    <li>
   <span><strong>·</strong> Guaranteed authentic products, 24/7 customer support</span>
    </li>

    <li>
      <span><strong>·</strong> Safe & convenient shopping, Thank you for your trust</span>
    </li>

  </ul>
</div>


  </div>
</div>

<!-- TABS -->
<ul class="nav nav-tabs mt-5">
  <li class="nav-item">
    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#desc">
      Describe
    </button>
  </li>
  <li class="nav-item">
    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#policy">
      Policy
    </button>
  </li>
</ul>

<div class="tab-content border border-top-0 p-3">
  <div class="tab-pane fade show active" id="desc">
    <?= nl2br(e($p['description'] ?: 'Sản phẩm chất lượng cao, phù hợp sử dụng hằng ngày.')) ?>
  </div>
  <div class="tab-pane fade" id="policy">
    <ul class="mb-0">
      <li>Returns accepted within 7 days if manufacturer defect</li>
      <li>Refunds processed within 3-5 business days</li>
      <li>24/7 customer support</li>
    </ul>
  </div>
</div>

<!-- RELATED -->
<?php
$rel = db()->query("
  SELECT id,name,price,thumbnail 
  FROM products 
  WHERE is_active=1 AND id != {$p['id']}
  ORDER BY RAND() LIMIT 4
")->fetchAll();
?>

<?php if ($rel): ?>
<hr class="my-5">
<h5 class="mb-3">Related products</h5>

<div class="row g-3">
<?php foreach ($rel as $r): ?>
  <div class="col-md-3">
    <a href="/product.php?id=<?= $r['id'] ?>" class="text-decoration-none text-dark">
      <div class="card h-100 related-card">
        <img src="/<?= e($r['thumbnail'] ?: 'uploads/placeholder.png') ?>"
             class="card-img-top">
        <div class="card-body">
          <h6 class="card-title"><?= e($r['name']) ?></h6>
          <strong><?= money($r['price']) ?></strong>
        </div>
      </div>
    </a>
  </div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php endif; ?>
</main>




<?php require_once __DIR__ . '/partials/footer.php'; ?>
