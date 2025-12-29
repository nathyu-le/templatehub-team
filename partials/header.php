<?php
require_once __DIR__ . '/../core/bootstrap.php';

$user = current_user();
$cartCount = $user ? cart_count_items_by_user((int)$user['id']) : 0;
?>

<!-- HEADER -->
<header class="sticky top-0 z-50 bg-white border-b">
  <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

    <!-- LOGO -->
    <a href="/index.php" class="flex items-center gap-2">
      <img src="/uploads/logo.png" alt="Logo" class="h-10">
    </a>

    <!-- NAV -->
    <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
      <a href="/index.php" class="hover:text-orange-500 transition">Home</a>
      <a href="/products.php" class="hover:text-orange-500 transition">Products</a>
      <a href="/collections.php" class="hover:text-orange-500 transition">Collections</a>
      <a href="/blog.php" class="hover:text-orange-500 transition">Blog</a>
      <a href="/index.php#contact" class="hover:text-orange-500 transition">Contact</a>
    </nav>

    <!-- RIGHT -->
    <div class="flex items-center gap-4">

      <!-- CART -->
      <a href="/cart.php" class="relative">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-6 h-6 text-gray-800"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m12-9l2 9m-5-9v9"/>
        </svg>

        <?php if ($cartCount > 0): ?>
          <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs rounded-full px-1.5">
            <?= (int)$cartCount ?>
          </span>
        <?php endif; ?>
      </a>

      <!-- USER -->
      <?php if ($user): ?>
        <div class="relative">

          <!-- BUTTON -->
          <button
            id="userBtn"
            class="bg-black text-white text-sm px-3 py-1.5 rounded flex items-center gap-1">
            <?= e($user['full_name']) ?>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <!-- DROPDOWN -->
          <div
            id="userMenu"
            class="absolute right-0 mt-2 w-44 bg-white border rounded-lg shadow-lg hidden z-[9999]"
          >
            <?php if (($user['role'] ?? '') === 'admin'): ?>
              <a href="/admin/index.php"
                 class="block px-4 py-2 text-sm hover:bg-gray-100 transition">
                Admin
              </a>
            <?php endif; ?>
            <a href="/logout.php"
               class="block px-4 py-2 text-sm hover:bg-gray-100 transition">
              Logout
            </a>
          </div>

        </div>
      <?php else: ?>
        <a href="/login.php"
           class="text-sm px-3 py-1.5 border rounded hover:bg-gray-100 transition">
          Login
        </a>
        <a href="/register.php"
           class="text-sm px-3 py-1.5 bg-black text-white rounded hover:opacity-90 transition">
          Register
        </a>
      <?php endif; ?>

    </div>
  </div>
</header>

<!-- SCRIPT: DROPDOWN -->
<script>
  const btn = document.getElementById('userBtn');
  const menu = document.getElementById('userMenu');

  if (btn && menu) {
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      menu.classList.toggle('hidden');
    });

    document.addEventListener('click', function () {
      menu.classList.add('hidden');
    });
  }
</script>
