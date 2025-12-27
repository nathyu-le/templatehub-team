<?php
// partials/header.php
require_once __DIR__ . '/../core/bootstrap.php';

$user = current_user();
$cartCount = $user ? cart_count_items_by_user((int)$user['id']) : 0;
?>

<div class="topbar py-1">
  <div class="container text-center">
Free shipping within city &gt; 300K • 7-day returns • Support 24/7  </div>
</div>

<nav class="navbar navbar-expand-lg header sticky-top">
  <div class="container">

    <a class="navbar-brand fw-bold" href="/index.php" style="letter-spacing:.5px;">
      <img style="weight: 100px; height:50px;" src="uploads/logo.png" alt="#">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav mx-auto gap-lg-3 align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link" href="/index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/products.php">Products</a>
        </li>

        <!-- anchor sections on Home -->
        <li class="nav-item">
          <a class="nav-link" href="/collections.php">Collections</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/blog.php">Blog</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/index.php#contact">Contact</a>
        </li>
      </ul>

      <div class="d-flex align-items-center gap-2">

        <a class="icon-btn position-relative" href="/cart.php" title="Cart" aria-label="Cart">
         <i class="fi fi-tr-shopping-basket"></i>
<style>
    .fi {
  font-size: 22px;
  color: #111;
}

</style>
          <?php if ($cartCount > 0): ?>
            <span class="badge rounded-pill badge-soft" data-cart-count><?= (int)$cartCount ?></span>
          <?php endif; ?>
        </a>

        <?php if ($user): ?>
          <div class="dropdown">
            <button class="btn btn-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <?= e($user['full_name']) ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php if (($user['role'] ?? '') === 'admin'): ?>
                <li><a class="dropdown-item" href="/admin/index.php">Admin</a></li>
                <li><hr class="dropdown-divider"></li>
              <?php endif; ?>
              <li><a class="dropdown-item" href="/logout.php">Logout</a></li>
            </ul>
          </div>
        <?php else: ?>
          <a class="btn btn-outline-dark btn-sm" href="/login.php">Login</a>
          <a class="btn btn-dark btn-sm" href="/register.php">Register</a>
        <?php endif; ?>

      </div>
    </div>
  </div>
</nav>
