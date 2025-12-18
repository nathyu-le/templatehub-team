<?php
$page_title = "Register";
require_once __DIR__ . '/core/bootstrap.php';

$err = '';
$ok = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = trim(post('full_name'));
  $email     = strtolower(trim(post('email')));
  $phone     = trim(post('phone'));
  $pass      = (string)post('password');
  $pass2     = (string)post('password2');

  if ($full_name === '' || $email === '' || $pass === '' || $pass2 === '') {
    $err = "Vui lòng nhập đủ thông tin.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $err = "Email không hợp lệ.";
  } elseif (strlen($pass) < 6) {
    $err = "Mật khẩu tối thiểu 6 ký tự.";
  } elseif ($pass !== $pass2) {
    $err = "Nhập lại mật khẩu không khớp.";
  } else {
    // check email exists
    $st = db()->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
    $st->execute([$email]);
    if ($st->fetch()) {
      $err = "Email đã tồn tại.";
    } else {
      $hash = password_hash($pass, PASSWORD_DEFAULT);

      $st = db()->prepare("INSERT INTO users(full_name,email,phone,password_hash,role,status) VALUES(?,?,?,?, 'user', 1)");
      $st->execute([$full_name, $email, ($phone !== '' ? $phone : null), $hash]);

      $ok = "Tạo tài khoản thành công. Bạn có thể đăng nhập.";
    }
  }
}

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';
?>

<main class="container my-4" style="max-width: 520px;">
  <h1 class="h4 mb-3">Đăng ký</h1>

  <?php if ($err): ?>
    <div class="alert alert-danger"><?= e($err) ?></div>
  <?php endif; ?>

  <?php if ($ok): ?>
    <div class="alert alert-success"><?= e($ok) ?></div>
  <?php endif; ?>

  <div class="card p-3">
    <form method="post" class="row g-3">
      <div class="col-12">
        <label class="form-label">Họ tên</label>
        <input class="form-control" name="full_name" required value="<?= e(post('full_name','')) ?>">
      </div>

      <div class="col-12">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" required value="<?= e(post('email','')) ?>">
      </div>

      <div class="col-12">
        <label class="form-label">SĐT (tuỳ chọn)</label>
        <input class="form-control" name="phone" value="<?= e(post('phone','')) ?>">
      </div>

      <div class="col-12">
        <label class="form-label">Mật khẩu</label>
        <input class="form-control" type="password" name="password" required>
      </div>

      <div class="col-12">
        <label class="form-label">Nhập lại mật khẩu</label>
        <input class="form-control" type="password" name="password2" required>
      </div>

      <div class="col-12 d-grid">
        <button class="btn btn-cta">Tạo tài khoản</button>
      </div>
<style> .btn-cta {
  background: #ff7a00;
  color: #fff;
}
</style>
      <div class="col-12 small text-muted">
        Đã có tài khoản? <a href="/login.php" class="link-dark">Đăng nhập</a>
      </div>
    </form>
  </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
