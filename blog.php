<?php
$page_title = "Journal & Blog";
require_once __DIR__ . '/core/bootstrap.php';

$blogs = db()->query("
  SELECT id, title, content, image, created_at
  FROM blogs
  WHERE status = 1
  ORDER BY created_at DESC
")->fetchAll();

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';

function excerpt($text, $limit = 120) {
  $text = strip_tags($text);
  return mb_strlen($text) > $limit
    ? mb_substr($text, 0, $limit) . '…'
    : $text;
}
?>

<!-- HERO VIDEO -->
<section class="relative min-h-[70vh] flex items-center justify-center text-center overflow-hidden">
  <video autoplay muted loop playsinline
    class="absolute inset-0 w-full h-full object-cover">
    <source src="/uploads/baner1.mp4" type="video/mp4">
  </video>

  <div class="absolute inset-0 bg-black/55"></div>

  <!-- HERO TEXT -->
  <div class="relative z-10 max-w-3xl px-6">
    <h1 class="text-white font-extrabold leading-tight
               text-[clamp(2.8rem,6vw,5rem)]">
      Journal & Blog
    </h1>

    <p class="mt-4 text-white/70 text-base md:text-lg">
      New trends, culture & fashion stories curated for you
    </p>
  </div>
</section>

<!-- BLOG SECTION -->
<section class="max-w-7xl mx-auto px-6 py-24">

  <!-- SECTION HEAD -->
  <div class="flex items-end justify-between mb-14">
    <div>
      <h2 class="text-3xl font-extrabold">Latest Stories</h2>
      <p class="mt-2 text-gray-500">new trends and articles</p>
    </div>
    <a href="/products.php"
       class="text-sm uppercase tracking-wider border px-4 py-2 rounded-full
              hover:bg-black hover:text-white transition">
      Buy Product
    </a>
  </div>

  <!-- BLOG GRID -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

    <?php foreach ($blogs as $b):
      $imgPath = 'uploads/blogs/' . $b['image'];
      $img = (!empty($b['image']) && file_exists($imgPath))
        ? $imgPath
        : 'uploads/placeholder.png';
    ?>

    <!-- BLOG CARD -->
    <article class="group relative rounded-3xl overflow-hidden h-[420px] bg-black">

      <!-- IMAGE -->
      <img
        src="<?= e($img) ?>"
        alt="<?= e($b['title']) ?>"
        class="
          absolute inset-0 w-full h-full
          object-cover
          md:object-cover
          object-contain
          transition-transform duration-[1200ms]
          group-hover:scale-105
          max-h-[420px]
        "
      >

      <!-- OVERLAY -->
      <div class="absolute inset-0 bg-gradient-to-t
                  from-black/70 via-black/30 to-transparent"></div>

      <!-- CONTENT -->
      <div class="
        absolute bottom-6 left-6 right-6
        bg-white/95 backdrop-blur
        rounded-2xl p-6
        transition-all duration-500
        translate-y-6 opacity-0
        group-hover:translate-y-0 group-hover:opacity-100
        md:opacity-0 md:translate-y-6
        opacity-100 translate-y-0
      ">
        <span class="text-xs uppercase tracking-widest text-gray-500">
          <?= date('M Y', strtotime($b['created_at'])) ?>
        </span>

        <h3 class="mt-3 text-lg font-bold leading-snug">
          <?= e($b['title']) ?>
        </h3>

        <p class="mt-2 text-sm text-gray-600 line-clamp-2">
          <?= e(excerpt($b['content'], 100)) ?>
        </p>

        <a href="/blog_detail.php?id=<?= (int)$b['id'] ?>"
           class="inline-block mt-4 text-xs uppercase tracking-wider">
          Read story →
        </a>
      </div>

    </article>

    <?php endforeach; ?>

  </div>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
