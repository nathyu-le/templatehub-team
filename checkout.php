<?php
$page_title = "Thanh toán";
require_once __DIR__ . '/core/bootstrap.php';
require_login();

$userId = (int)current_user()['id'];
$items = cart_get_items($userId);
if (!$items) redirect('/cart.php');

$subtotal = 0;
foreach ($items as $it) $subtotal += (float)$it['line_total'];

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = trim(post('full_name'));
  $phone = trim(post('phone'));
  $address = trim(post('address'));
  $note = trim(post('note'));
  $payment_method = post('payment_method','cod');

  if ($full_name === '' || $phone === '' || $address === '') {
    $err = 'Vui lòng nhập đủ thông tin.';
  } else {
    $orderId = cart_checkout($userId, compact('full_name','phone','address','note','payment_method'));
    if ($orderId) redirect('/order_success.php?id='.$orderId);
    $err = 'Đặt hàng thất bại.';
  }
}

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';
?>

<main class="container my-4">
  <h1 class="h4 mb-3">Thanh toán</h1>

  <?php if ($err): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endif; ?>

  <div class="row g-3">
    <div class="col-lg-7">
      <div class="card p-3">
        <form method="post" class="row g-3">
          <div class="col-12">
            <label class="form-label">Họ tên</label>
            <input class="form-control" name="full_name" required>
          </div>
          <div class="col-12">
            <label class="form-label">SĐT</label>
            <input class="form-control" name="phone" required>
          </div>
          <div class="col-12">
            <label class="form-label">Địa chỉ</label>
            <input class="form-control" name="address" required>
          </div>
          <div class="col-12">
            <label class="form-label">Ghi chú</label>
            <input class="form-control" name="note">
          </div>
          <div class="col-12">
            <label class="form-label">Thanh toán</label>
            <select class="form-select" name="payment_method">
              <option value="cod">COD</option>
              <option value="bank">Chuyển khoản</option>
              <option value="momo">MoMo</option>
            </select>
          </div>
          <div class="col-12 d-grid">
            <button style="
  background: #ff7a00;
  color: #fff;
" class="btn btn-cta">Đặt hàng</button>
          </div>
        </form>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card p-3">
        <b class="mb-2 d-block">Tóm tắt</b>
        <?php foreach ($items as $it): ?>
          <div class="d-flex justify-content-between small mb-2">
            <span class="text-muted"><?= e($it['name']) ?> × <?= (int)$it['quantity'] ?></span>
            <span><?= money($it['line_total']) ?></span>
          </div>
        <?php endforeach; ?>
        <hr>
        <div class="d-flex justify-content-between">
          <span class="text-muted">Tạm tính</span>
          <b><?= money($subtotal) ?></b>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
