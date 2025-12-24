<?php
$page_title = "Home";
require_once __DIR__ . '/core/bootstrap.php';

$new = db()->query("
  SELECT id, name, price, sale_price, thumbnail
  FROM products
  WHERE is_active=1
  ORDER BY id DESC
  LIMIT 8
")->fetchAll();

$hot = db()->query("
  SELECT id, name, price, sale_price, thumbnail
  FROM products
  WHERE is_active=1
  ORDER BY id DESC
  LIMIT 8
")->fetchAll();
$best = db()->query("
  SELECT p.*, SUM(oi.quantity) AS sold_qty
  FROM order_items oi
  JOIN orders o ON o.id = oi.order_id
  JOIN products p ON p.id = oi.product_id
  WHERE p.is_active = 1
    AND o.order_status = 'done'
  GROUP BY p.id
  ORDER BY sold_qty DESC
  LIMIT 8
")->fetchAll();

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';
?>

<section class="hero-lambo" id="hero">
  <div class="hero-bg">

 <video class="hero-video" autoplay muted loop playsinline poster="/uploads/hero-poster.jpg">
      <source src="/uploads/baner1.mp4" type="video/mp4">
    </video>

 
 <!--  <img class="hero-image" src="https://theme.hstatic.net/1000375638/1001229554/14/slideshow_1.jpg?v=14" alt=""> -->

    <div class="hero-overlay"></div>
  </div>

  <div class="container hero-content">
    <div class="hero-left">
      <div class="hero-kicker"></div>
      <h1 class="hero-title"></h1>

      <a class="hero-btn" href="/products.php">
        DISCOVER MORE <span class="arrow">→</span>
      </a>
    </div>

    <div class="hero-right">
      <div class="hero-dots" data-hero-dots>
        <button class="dot is-active" data-hero-go="0" aria-label="Slide 1"></button>
        <button class="dot" data-hero-go="1" aria-label="Slide 2"></button>
        <button class="dot" data-hero-go="2" aria-label="Slide 3"></button>
      </div>

      <button type="button" class="hero-pause" data-hero-toggle aria-label="Pause/Play">
  <span class="icon">Ⅱ</span>
</button>
    </div>
  </div>

  <div class="hero-footer">
    <div class="container">
      <div class="hero-legal">
      We are the best store you can choose.
      </div>
    </div>
  </div>
</section>

  <!-- NEWSLETTER -->
  <section class="container my-5">
  <iframe
    src="tailwind/tailwind-demo.html"
    style="width:100%;border:0;overflow:hidden;display:block;"
    height="170"
    loading="lazy">
  </iframe>
</section>
<main class="container">

  <!-- NEW -->
  <div id="new" class="section-head">
    <div>
      <h2>New Arrivals</h2> 
      <div class="sub">the latest product has been updated.</div>
    </div>
    <a class="btn btn-outline-dark btn-sm" href="/products.php">View all</a>
  </div>

 <div class="row g-3">
  <?php foreach ($new as $p): 
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

         <section id="collections">
  <!-- COLLECTION -->
  <div class="section-head">
    <div>
      <h2>Collections</h2>
      <div class="sub">we design according to your style.</div>
    </div>
  </div>
<iframe
    src="tailwind/tailwind-collections.html"
    style="width:100%;border:0;overflow:hidden;display:block;"
    height="260"
    loading="lazy">
  </iframe>
</section>
  <!-- BEST SELLER -->
  <div class="section-head">
    <div>
      <h2>Best sellers</h2>
      <div class="sub">Được mua nhiều nhất</div>
    </div>
    <a class="btn btn-outline-dark btn-sm" href="/products.php">View all</a>
  </div>

 <div class="row g-3">
  <?php foreach ($best as $p): 
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

    <section id="blog">    
  <!-- BLOG -->
  <div class="section-head">
    <div>
      <h2>Journal & Blog</h2>
      <div class="sub">new trends and articles</div>
    </div>
    <a class="btn btn-outline-dark btn-sm" href="#">Read more</a>
  </div>

<?php include __DIR__ . '/tailwind/tailwind-blog.php'; ?>
</section>
  </div>
  </section>
<br>
 



</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
