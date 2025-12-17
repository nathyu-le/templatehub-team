<?php
// partials/product_item.php
// require: $p (product row) + $final + $thumb

$thumb = $thumb ?? ($p['thumbnail'] ?: 'uploads/placeholder.png');
$final = $final ?? ($p['sale_price'] ?? $p['price']);
?>

<div class="showcase">
  <a class="showcase-img" href="/product.php?id=<?= (int)$p['id'] ?>">
    <img src="/<?= e($thumb) ?>" alt="<?= e($p['name']) ?>">
  </a>

  <div class="showcase-info">
    <div class="showcase-name"><?= e($p['name']) ?></div>
    <div class="showcase-price"><?= money($final) ?></div>

    <!-- Nếu bạn muốn đúng kiểu ảnh 2 thì nên ẨN nút add, chỉ click vào sản phẩm -->
    <!-- Còn muốn vẫn có add thì để hover như dưới -->
    <button type="button" class="showcase-add" data-add-cart="<?= (int)$p['id'] ?>">
      Add To Card
    </button>
  </div>
</div>
