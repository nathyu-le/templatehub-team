<?php
$page_title = "Collections";
require_once __DIR__ . '/core/bootstrap.php';

$collections = db()
  ->query("SELECT id,title,subtitle,image FROM collections ORDER BY created_at DESC")
  ->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title><?= $page_title ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/assets/css/collections.css?v=6">

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      fontFamily: {
        display: ['Poppins','sans-serif'],
      }
    }
  }
}
</script>
</head>

<body class="bg-white text-gray-900">

<!-- HEADER -->
<header class="editorial-header">
  <div class="wrap">
    <h1 class="logo">COLLECTIONS</h1>
    <nav>
      <a href="/">Home</a>
    </nav>
  </div>
</header>

<!-- HERO -->
<section class="editorial-hero">
  <h2>Defined by style,<br>not trends.</h2>
  <p>Each collection is a statement, not a product.</p>
</section>

<!-- COLLECTIONS -->
<section class="editorial-collections">
<?php foreach ($collections as $i => $c):
  $imagePath = 'uploads/collections/' . $c['image'];
  $image = (!empty($c['image']) && file_exists($imagePath)) ? $imagePath : 'uploads/placeholder.png';
?>
  <article class="editorial-row <?= $i % 2 ? 'reverse' : '' ?>">
    
    <div class="editorial-text">
      <span class="editorial-index">
        <?= str_pad($i+1, 2, '0', STR_PAD_LEFT) ?>
      </span>
      <h3><?= e($c['title']) ?></h3>
      <p><?= e($c['subtitle']) ?></p>
      <a href="products.php" class="editorial-link">
        Explore collection →
      </a>
    </div>

    <div class="editorial-image">
      <img src="<?= e($image) ?>" alt="<?= e($c['title']) ?>">
    </div>

  </article>
<?php endforeach; ?>
</section>

<!-- FOOTER -->
<footer class="editorial-footer">
  <p>Collections © 2025</p>
</footer>

</body>
</html>
