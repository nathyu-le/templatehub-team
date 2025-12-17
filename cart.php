<?php
$page_title = "Giỏ hàng";
require_once __DIR__ . '/core/bootstrap.php';
require_login();

$userId = (int)current_user()['id'];

/**
 * Fallback (không JS) — vẫn chạy bình thường
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = post('action');
  $cartItemId = (int)post('cart_item_id', 0);

  if ($cartItemId > 0) {
    if ($action === 'update') {
      $qty = max(1, (int)post('quantity', 1));
      cart_update_qty($userId, $cartItemId, $qty);
    }
    if ($action === 'remove') {
      cart_remove_item($userId, $cartItemId);
    }
  }
  redirect('/cart.php');
}

$items = cart_get_items($userId);

// subtotal
$subtotal = 0;
foreach ($items as $it) $subtotal += (float)$it['line_total'];

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/header.php';
?>

<main class="container my-4">
  <div class="d-flex align-items-end justify-content-between mb-3">
    <div>
      <h1 class="h4 mb-1">Giỏ hàng</h1>
      <div class="text-muted" style="font-size:13px;">
        Xem lại sản phẩm trước khi thanh toán
      </div>
    </div>

    <a class="btn btn-outline-dark btn-sm" href="/products.php">Tiếp tục mua sắm</a>
  </div>

  <?php if (!$items): ?>
    <div class="border rounded-4 p-4 bg-white">
      <div class="text-muted mb-3">Giỏ hàng đang trống.</div>
      <a class="btn btn-primary" href="/products.php">Mua ngay</a>
    </div>
  <?php else: ?>
    <div class="row g-3">
      <!-- LEFT: items -->
      <div class="col-lg-8">

        <?php foreach ($items as $it):
          $cartItemId = (int)$it['cart_item_id'];
          $thumb = $it['thumbnail'] ?: 'uploads/placeholder.png';
        ?>
          <div class="border rounded-4 p-3 bg-white mb-3" data-cart-row>
            <div class="d-flex gap-3">
              <a href="/product.php?id=<?= (int)$it['product_id'] ?>">
                <img
                  src="/<?= e($thumb) ?>"
                  alt=""
                  width="84"
                  height="84"
                  style="object-fit:cover;border-radius:14px;border:1px solid #e5e7eb;"
                >
              </a>

              <div class="flex-grow-1">
                <div class="d-flex justify-content-between gap-3">
                  <div>
                    <a href="/product.php?id=<?= (int)$it['product_id'] ?>" class="fw-bold" style="font-size:14px;">
                      <?= e($it['name']) ?>
                    </a>
                    <div class="text-muted" style="font-size:13px;">
                      Đơn giá: <b><?= money($it['unit_price']) ?></b>
                    </div>
                  </div>

                  <div class="text-end">
                    <div class="fw-bold" style="font-size:14px;" data-line-total="<?= $cartItemId ?>">
                      <?= money($it['line_total']) ?>
                    </div>
                    <div class="text-muted" style="font-size:12px;">Thành tiền</div>
                  </div>
                </div>

                <div class="d-flex align-items-center gap-2 mt-3 flex-wrap">
                  <!-- Qty input (JS uses data-cart-qty="id") -->
                  <div class="d-flex align-items-center gap-2">
                    <span class="text-muted" style="font-size:13px;">Số lượng</span>
                    <input
                      type="number"
                      min="1"
                      class="form-control form-control-sm"
                      style="width:92px;"
                      value="<?= (int)$it['quantity'] ?>"
                      data-cart-qty="<?= $cartItemId ?>"
                    >
                  </div>

                  <!-- Buttons: JS intercepts, fallback submits -->
                  <form method="post" class="ms-auto d-flex gap-2">
                    <input type="hidden" name="cart_item_id" value="<?= $cartItemId ?>">

                    <!-- Update -->
                    <input type="hidden" name="action" value="update">
                    <!-- Fallback quantity for non-JS -->
                    <input type="hidden" name="quantity" value="<?= (int)$it['quantity'] ?>" data-fallback-qty="<?= $cartItemId ?>">

                    <button
                      type="submit"
                      class="btn btn-outline-dark btn-sm"
                      data-cart-update="<?= $cartItemId ?>"
                      onclick="
                        // fallback sync: copy visible qty -> hidden qty
                        (function(){
                          var v=document.querySelector('[data-cart-qty=\\'<?= $cartItemId ?>\\']');
                          var h=document.querySelector('[data-fallback-qty=\\'<?= $cartItemId ?>\\']');
                          if(v && h) h.value=v.value;
                        })();
                      "
                    >
                      Update
                    </button>
                  </form>

                  <form method="post">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="cart_item_id" value="<?= $cartItemId ?>">
                    <button
                      type="submit"
                      class="btn btn-outline-danger btn-sm"
                      data-cart-remove="<?= $cartItemId ?>"
                    >
                      Remove
                    </button>
                  </form>
                </div>

              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>

      <!-- RIGHT: summary -->
      <div class="col-lg-4">
        <div class="border rounded-4 p-3 bg-white">
          <div class="fw-bold mb-2">Tóm tắt</div>

          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted" style="font-size:13px;">Tạm tính</span>
            <b data-cart-subtotal><?= money($subtotal) ?></b>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted" style="font-size:13px;">Phí ship</span>
            <span class="text-muted" style="font-size:13px;">Tính khi thanh toán</span>
          </div>

          <a class="btn btn-primary w-100" href="/checkout.php">Thanh toán</a>

          <div class="text-muted mt-2" style="font-size:12px;">
            Mẹo: bấm Update sau khi đổi số lượng.
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
