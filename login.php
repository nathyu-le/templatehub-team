<?php
$page_title = "Login";
require_once __DIR__ . '/core/bootstrap.php';

ensure_session();
if (!empty($_SESSION['user_id'])) redirect('/index.php');

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = strtolower(trim(post('email')));
  $pass  = (string)post('password');

  if ($email === '' || $pass === '') {
    $err = "Vui lòng nhập email và mật khẩu.";
  } else {
    $st = db()->prepare("SELECT id, full_name, email, password_hash, role, status FROM users WHERE email=? LIMIT 1");
    $st->execute([$email]);
    $u = $st->fetch();

    if (!$u) {
      $err = "Email hoặc mật khẩu không đúng.";
    } elseif ((int)$u['status'] !== 1) {
      $err = "Tài khoản đang bị khoá.";
    } elseif (!password_verify($pass, $u['password_hash'])) {
      $err = "Email hoặc mật khẩu không đúng.";
    } else {
      auth_login((int)$u['id']);

      // điều hướng admin về /admin
      if ($u['role'] === 'admin') redirect('/admin/index.php');
      redirect('/index.php');
    }
  }
}

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';
?>

<main class="container my-4" style="max-width: 520px;">
  <h1 class="h4 mb-3">Đăng nhập</h1>

  <?php if ($err): ?>
    <div class="alert alert-danger"><?= e($err) ?></div>
  <?php endif; ?>

  <div class="card p-3">
    <form method="post" class="row g-3">
      <div class="col-12">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" required value="<?= e(post('email','')) ?>">
      </div>

      <div class="col-12">
        <label class="form-label">Mật khẩu</label>
        <input class="form-control" type="password" name="password" required>
      </div>

      <div class="col-12 d-grid">
        <button class="btn btn-primary">Đăng nhập</button>
      </div>

      <div class="col-12 small text-muted">
        Chưa có tài khoản? <a href="/register.php" class="link-light">Đăng ký</a>
      </div>
    </form>
  </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
