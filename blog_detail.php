<?php
require_once __DIR__ . '/core/bootstrap.php';

$id = (int)($_GET['id'] ?? 0);
$st = db()->prepare("SELECT * FROM blogs WHERE id=? AND status=1 LIMIT 1");
$st->execute([$id]);
$blog = $st->fetch();

if (!$blog) {
  http_response_code(404);
  die("Không tìm thấy bài viết");
}

$imagePath = 'uploads/blogs/' . $blog['image'];
$image = (!empty($blog['image']) && file_exists($imagePath))
  ? $imagePath
  : 'uploads/placeholder.png';

$page_title = $blog['title'];

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';
?>

<!-- HERO -->
<section class="relative h-[75vh] md:h-[85vh] w-full overflow-hidden">

  <!-- IMAGE -->
  <img
    src="<?= e($image) ?>"
    alt="<?= e($blog['title']) ?>"
    class="absolute inset-0 w-full h-full object-cover"
  >

  <!-- OVERLAY -->
  <div class="absolute inset-0 bg-black/45"></div>

  <!-- TEXT -->
  <div class="absolute inset-0 flex items-end">
    <div class="max-w-5xl px-6 pb-16 md:pb-24 text-white">
      <p class="text-xs tracking-widest uppercase opacity-80 mb-3">
        <?= date('F d, Y', strtotime($blog['created_at'])) ?>
      </p>

      <h1 class="text-3xl md:text-5xl font-extrabold leading-tight max-w-3xl">
        <?= e($blog['title']) ?>
      </h1>
    </div>
  </div>
</section>

<!-- CONTENT -->
<main class="max-w-4xl mx-auto px-6 py-16">

  <!-- ARTICLE -->
  <article class="blog-article">

  <!-- LEAD -->
  <p class="lead">
    <?= e(mb_substr(strip_tags($blog['content']), 0, 180)) ?>...
  </p>

  <!-- FULL CONTENT -->
  <?= $blog['content'] ?>

</article>

  <!-- DIVIDER -->
  <div class="my-20 border-t"></div>

  <!-- BACK -->
  <div class="text-center">
    <a
      href="/blog.php"
      class="inline-block text-sm tracking-wide font-medium text-gray-600 hover:text-black transition"
    >
      ← Back to Blog
    </a>
  </div>

</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
