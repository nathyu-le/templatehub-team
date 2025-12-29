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
/* COLLECTIONS – LIMIT 3 */
$collections_home = db()->query("
  SELECT id, title, subtitle, image
  FROM collections
  ORDER BY id DESC
  LIMIT 3
")->fetchAll();

/* BLOG – LIMIT 3 */
$blogs_home = db()->query("
  SELECT id, title, image, created_at, content
  FROM blogs
  ORDER BY created_at DESC
  LIMIT 3
")->fetchAll();

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';
?>

<!-- HERO LAMBO STYLE -->
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

      <button class="hero-pause" data-hero-toggle aria-label="Pause/Play">
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
  <section class="max-w-7xl mx-auto px-6 py-12">
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

    <!-- ITEM 1 -->
    <div class="relative rounded-xl overflow-hidden h-32">
      <img src="/uploads/ft1.jpg"
           class="absolute inset-0 w-full h-full object-cover opacity-80">
      <div class="absolute inset-0 bg-white/70"></div>

      <div class="relative z-10 h-full flex flex-col items-center justify-center">
        <div class="text-2xl font-bold">50K+</div>
        <div class="text-sm text-gray-600">Customer</div>
      </div>
    </div>

    <!-- ITEM 2 -->
    <div class="relative rounded-xl overflow-hidden h-32">
      <img src="/uploads/ft2.jpg"
           class="absolute inset-0 w-full h-full object-cover opacity-80">
      <div class="absolute inset-0 bg-white/70"></div>

      <div class="relative z-10 h-full flex flex-col items-center justify-center">
        <div class="text-2xl font-bold">99.9%</div>
        <div class="text-sm text-gray-600">Uptime</div>
      </div>
    </div>

    <!-- ITEM 3 -->
    <div class="relative rounded-xl overflow-hidden h-32">
      <img src="/uploads/ft3.jpg"
           class="absolute inset-0 w-full h-full object-cover opacity-80">
      <div class="absolute inset-0 bg-white/70"></div>

      <div class="relative z-10 h-full flex flex-col items-center justify-center">
        <div class="text-2xl font-bold">24/7</div>
        <div class="text-sm text-gray-600">Support</div>
      </div>
    </div>

    <!-- ITEM 4 -->
    <div class="relative rounded-xl overflow-hidden h-32">
      <img src="/uploads/ft4.jpg"
           class="absolute inset-0 w-full h-full object-cover opacity-80">
      <div class="absolute inset-0 bg-white/70"></div>

      <div class="relative z-10 h-full flex flex-col items-center justify-center">
        <div class="text-2xl font-bold">100+</div>
        <div class="text-sm text-gray-600">Features</div>
      </div>
    </div>

  </div>
</section>

<br>
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
    $final = $p['sale_price'] ?? $p['price'];
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

<div class="row g-3 cgrid">
  <?php foreach ($collections_home as $c): 
    $img = $c['image'] ? '/uploads/collections/'.$c['image'] : '/uploads/placeholder.png';
  ?>
    <div class="col-md-4">
      <a class="citem d-block" href="/products.php?collection=<?= $c['id'] ?>">
        <img src="<?= e($img) ?>" alt="<?= e($c['title']) ?>">
        <div class="cover"></div>
        <div class="txt">
          <div class="t"><?= e($c['title']) ?></div>
          <div class="d"><?= e($c['subtitle']) ?></div>
        </div>
      </a>
    </div>
  <?php endforeach; ?>
</div>


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
    $final = $p['sale_price'] ?? $p['price'];
    $thumb = $p['thumbnail'] ?: 'uploads/placeholder.png';
  ?>
    <div class="col-6 col-md-3">
      <?php require __DIR__ . '/partials/product_item.php'; ?>
    </div>
  <?php endforeach; ?>
</div>

    <section id="blog">    
  <!-- BLOG -->
 <!-- BLOG -->
<div class="section-head">
  <div>
    <h2>Journal & Blog</h2>
    <div class="sub">new trends and articles</div>
  </div>
  <a class="btn btn-outline-dark btn-sm" href="/blog.php">Read more</a>
</div>

<div class="row g-3">
  <?php foreach ($blogs_home as $b):
    $img = $b['image'] ? '/uploads/blogs/'.$b['image'] : '/uploads/placeholder.png';
  ?>
    <div class="col-md-4">
      <a href="/blog_detail.php?id=<?= $b['id'] ?>" class="blog-link">
        <div class="blogcard">
          <img src="<?= e($img) ?>" alt="<?= e($b['title']) ?>">
          <div class="b">
            <div class="date">
              <?= date('M Y', strtotime($b['created_at'])) ?>
            </div>
            <div class="title"><?= e($b['title']) ?></div>
            <p class="desc">
              <?= e(mb_strimwidth(strip_tags($b['content']), 0, 150, '...')) ?>
            </p>
          </div>
        </div>
      </a>
    </div>
  <?php endforeach; ?>
</div>

<br>
 



</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
