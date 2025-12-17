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
  <section class="shop-stats">
  <div class="container">
    <div class="row g-3 justify-content-center">
     <div class="col-6 col-md-3">
  <div class="shop-stat-card bg-users">
    <div class="num">50K+</div>
    <div class="label">Customer</div>
  </div>
</div>

<div class="col-6 col-md-3">
  <div class="shop-stat-card bg-uptime">
    <div class="num">99.9%</div>
    <div class="label">Uptime</div>
  </div>
</div>

<div class="col-6 col-md-3">
  <div class="shop-stat-card bg-support">
    <div class="num">24/7</div>
    <div class="label">Support</div>
  </div>
</div>

<div class="col-6 col-md-3">
  <div class="shop-stat-card bg-feature">
    <div class="num">100+</div>
    <div class="label">Features</div>
  </div>
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
    <div class="col-md-4">
      <a class="citem d-block" href="/products.php">
        <img src="/uploads/bst1.jpg" alt="">
        <div class="cover"></div>
        <div class="txt">
          <div class="t">LUXURIOUS STYLE</div>
          <div class="d">fashionable and elegant</div>
        </div>
      </a>
    </div>
    <div class="col-md-4">
      <a class="citem d-block" href="/products.php">
        <img src="/uploads/bst2.jpg" alt="">
        <div class="cover"></div>
        <div class="txt">
          <div class="t">SPORT STYLE</div>
          <div class="d">dynamic and individualistic</div>
        </div>
      </a>
    </div>
    <div class="col-md-4">
      <a class="citem d-block" href="/products.php">
        <img src="/uploads/bst3.jpg" alt="">
        <div class="cover"></div>
        <div class="txt">
          <div class="t">STREET STYLE</div>
          <div class="d">hip hop and cool</div>
        </div>
      </a>
    </div>
  </div>
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
  <div class="section-head">
    <div>
      <h2>Journal & Blog</h2>
      <div class="sub">new trends and articles</div>
    </div>
    <a class="btn btn-outline-dark btn-sm" href="#">Read more</a>
  </div>

  <div class="row g-3">
    <div class="col-md-4">
        <a href="https://ww.fashionnetwork.com/news/Portuguese-label-ementa-makes-its-paris-debut,1792330.html" class="blog-link">
      <div class="blogcard">
        <img src="/uploads/bl1.jpg" alt="">
        <div class="b">
          <div class="date">Dec 2025</div>
          <div class="title">Portuguese label Ementa makes its Paris debut</div>
          <p class="desc">Just a stone's throw from the bustle of Paris' Les Halles, Ementa’s new boutique at 11, rue Montmartre gleams in green. </p>
        </div>
      </div>
      </a>
    </div>
    <div class="col-md-4">
        <a href="http://ww.fashionnetwork.com/news/Rag-bone-names-swaim-hutson-head-of-menswear-design,1792288.html" class="blog-link">
      <div class="blogcard">
        <img src="/uploads/bl2.jpg" alt="">
        <div class="b">
          <div class="date">Dec 2025</div>
          <div class="title">Rag & Bone names Swaim Hutson head of menswear design</div>
          <p class="desc">The upcoming January edition of Pitti Uomo will mark Swaim Hutson’s debut as head of menswear design at Rag & Bone..</p>
        </div>
      </div>
      </a>
    </div>
    <div class="col-md-4">
        <a href="https://ww.fashionnetwork.com/news/Six-stories-is-expanding-at-pace-so-looks-for-major-hires,1792266.html" class="blog-link">
      <div class="blogcard">
        <img src="/uploads/bl3.jpg" alt="">
        <div class="b">
          <div class="date">Dec 2025</div>
          <div class="title">Six Stories is expanding at pace so looks for major hires</div>
          <p class="desc">UK fast-growing bridal and occasionwear brand Six Stories is on a major recruitment drive in order to support its “next phase of scale” backed by a “significant investment in senior talent”. ..</p>
        </div>
      </div>
      </a>
    </div>
  </div>
  </section>
<br>
 



</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
