<?php
$page_title = "Collections";
require_once __DIR__ . '/core/bootstrap.php';

$collections = db()
  ->query("SELECT id,title,subtitle,image FROM collections ORDER BY created_at DESC")
  ->fetchAll();
require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';
?>

<section class="relative min-h-[80vh] flex items-center">
  <video autoplay muted loop
    class="absolute inset-0 w-full h-full object-cover">
    <source src="/uploads/baner1.mp4">
  </video>

  <div class="absolute inset-0 bg-black/50"></div>

  <div class="relative z-10 px-[10%]">
    <h1 class="text-white text-[clamp(3rem,6vw,5rem)] font-extrabold">
      Defined by style,<br>not trends.
    </h1>
  </div>
</section>


<!-- COLLECTIONS -->
<section class="max-w-[1400px] mx-auto">
<?php foreach ($collections as $i => $c):
  $imagePath = 'uploads/collections/' . $c['image'];
  $image = (!empty($c['image']) && file_exists($imagePath)) ? $imagePath : 'uploads/placeholder.png';
?>
  <!-- ROW -->
  <article
    class="
      grid grid-cols-1 md:grid-cols-2
      items-center
      min-h-[90vh]
      <?= $i % 2 ? 'md:[direction:rtl]' : '' ?>
    "
  >
    
    <!-- TEXT -->
    <div class="p-[10%] md:[direction:ltr]">
      <span class="editorial-index">
        <?= str_pad($i+1, 2, '0', STR_PAD_LEFT) ?>
      </span>

      <h3 class="text-[clamp(2.5rem,4vw,4rem)] font-extrabold my-2">
        <?= e($c['title']) ?>
      </h3>

      <p class="max-w-[420px] text-[15px] leading-[1.7] opacity-70">
        <?= e($c['subtitle']) ?>
      </p>

      <a href="products.php" class="editorial-link mt-8 inline-block">
        Explore collection →
      </a>
    </div>

    <!-- IMAGE -->
    <div class="h-[70vh] overflow-hidden">
      <img
        src="<?= e($image) ?>"
        alt="<?= e($c['title']) ?>"
        class="w-full h-full object-cover transition-transform duration-[1200ms] hover:scale-[1.08]"
      >
    </div>

  </article>
<?php endforeach; ?>
</section>

<!-- FOOTER -->
<?php require_once __DIR__ . '/partials/footer.php'; ?>
