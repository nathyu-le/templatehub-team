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
$image = (!empty($blog['image']) && file_exists($imagePath)) ? $imagePath : 'uploads/placeholder.png';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title><?= e($blog['title']) ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/assets/css/blog.css">
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen">

<!-- HEADER -->
<header class="bg-gradient-to-r from-orange-600 via-orange-500 to-black text-black py-6 shadow-lg sticky top-0 z-50">
  <div class="max-w-5xl mx-auto flex justify-between items-center px-6">
    <a href="blog.php" class="text-orange-400 font-bold hover:underline">← BACK</a>
    <h1 class="font-extrabold text-2xl animate-pulse text-orange-400">Blog Detail</h1>
  </div>
</header>

<main class="max-w-5xl mx-auto px-6 py-12">
  <h2 class="text-3xl font-bold mb-4 text-gradient animate-text-glow">Title: <?= e($blog['title']) ?></h2>
  <p class="text-gray-500 mb-8">Date: <?= date('d/m/Y', strtotime($blog['created_at'])) ?></p>

  <div class="relative mb-12 overflow-hidden rounded-3xl shadow-lg">
    <div class="absolute -inset-2 card-bg-glow blur opacity-20"></div>
    <img src="<?= e($image) ?>" class="w-full object-cover rounded-3xl transform hover:scale-110 transition-transform duration-700">
  </div>

  <article class="prose prose-lg max-w-none animate-fade-in text-black-1000"> Content :
    <?= $blog['content'] ?>
  </article>
</main>


</body>
</html>
