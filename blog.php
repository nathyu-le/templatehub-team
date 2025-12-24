<?php
$page_title = "Creative Blog";
require_once __DIR__ . '/core/bootstrap.php';

$blogs = db()
    ->query("SELECT id,title,image,created_at FROM blogs WHERE status=1 ORDER BY created_at DESC")
    ->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title><?= $page_title ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/assets/css/blog.css">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { theme: { extend: { fontFamily: { display:['Poppins','sans-serif'] } } } }
</script>
</head>
<body class="bg-gradient-to-r from-purple-100 via-pink-50 to-yellow-100 min-h-screen">

<!-- HEADER -->
<header class="bg-gradient-to-r from-purple-500 via-pink-500 to-yellow-400 text-white py-6 shadow-lg sticky top-0 z-50">
  <div class="max-w-7xl mx-auto flex justify-between items-center px-6">
    <h1 class="text-3xl font-extrabold font-display animate-pulse">BLOG</h1>
    <nav class="space-x-4">
      <a href="/" class="hover:underline hover:text-yellow-200 transition">Home</a>
      
    </nav>
  </div>
</header>

<!-- HERO -->
<section class="text-center py-24">
  <h2 class="text-5xl font-extrabold mb-4 animate-fade-in">
    Journal & Blog 🔥
  </h2>
  <p class="text-lg text-gray-700 animate-fade-in-delay">
   new trends and articles!
  </p>
</section>

<!-- BLOG GRID -->
<main class="max-w-7xl mx-auto px-6 pb-20 grid md:grid-cols-3 gap-12">
<?php foreach ($blogs as $b):
    $imagePath = 'uploads/blogs/' . $b['image'];
    $image = (!empty($b['image']) && file_exists($imagePath)) ? $imagePath : 'uploads/placeholder.png';
?>
<article class="relative group card-glow hover:scale-105 transition-transform duration-500">
  <a href="blog_detail.php?id=<?= (int)$b['id'] ?>" class="relative block overflow-hidden rounded-3xl shadow-2xl">
    <div class="card-bg-glow absolute -inset-1 rounded-3xl blur opacity-40 group-hover:opacity-70 transition-all duration-500"></div>
    <img src="<?= e($image) ?>" class="h-56 w-full object-cover rounded-3xl transform group-hover:scale-110 transition-transform duration-700">
    <div class="p-6 relative z-10">
      <h3 class="text-xl font-medium mb-2 text-gradient animate-text-glow"><?= e($b['title']) ?></h3>
      <p class="text-black-700 text-sm mb-3">date <?= date('d/m/Y', strtotime($b['created_at'])) ?></p>
      <span class="text-yellow-400 font-semibold hover:underline">Read more →</span>
    </div>
  </a>
</article>
<?php endforeach; ?>
</main>

<!-- FOOTER -->
<footer class="bg-gradient-to-r from-purple-600 via-pink-500 to-yellow-400 text-white py-4 mt-12">
  <div class="max-w-7xl mx-auto text-center space-y-2">
    <p class="font-bold"> Blog © 2025</p>
   
  </div>
</footer>
</body>
</html>
