<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';

/**
 * Make slug (NO mbstring required)
 */
function make_slug(string $s): string {
  $s = trim($s);
  if ($s === '') return '';

  // nếu có iconv thì convert tiếng Việt -> latin
  if (function_exists('iconv')) {
    $tmp = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s);
    if ($tmp !== false) $s = $tmp;
  }

  $s = strtolower($s);
  // giữ chữ + số, đổi phần còn lại thành "-"
  $s = preg_replace('/[^a-z0-9]+/', '-', $s);
  $s = trim($s, '-');
  $s = preg_replace('/-+/', '-', $s);

  return $s ?: 'product';
}

/**
 * Ensure unique slug in products table.
 * If exists -> append -2, -3...
 */
function ensure_unique_product_slug(string $baseSlug, int $ignoreId = 0): string {
  $baseSlug = make_slug($baseSlug);
  $pdo = db();

  $slug = $baseSlug;
  $i = 2;

  while (true) {
    if ($ignoreId > 0) {
      $st = $pdo->prepare("SELECT id FROM products WHERE slug=? AND id<>? LIMIT 1");
      $st->execute([$slug, $ignoreId]);
    } else {
      $st = $pdo->prepare("SELECT id FROM products WHERE slug=? LIMIT 1");
      $st->execute([$slug]);
    }

    $exists = $st->fetch();
    if (!$exists) return $slug;

    $slug = $baseSlug . '-' . $i;
    $i++;
    if ($i > 200) return $baseSlug . '-' . time(); // cứu hộ
  }
}

$id = (int)($_GET['id'] ?? 0);
$isEdit = $id > 0;

$cats = db()->query("SELECT id,name FROM categories ORDER BY name")->fetchAll();

$product = [
  'category_id' => null,
  'name' => '',
  'slug' => '',
  'description' => '',
  'price' => 0,
  'sale_price' => null,
  'stock' => 0,
  'thumbnail' => '',
  'is_active' => 1,
];

if ($isEdit) {
  $st = db()->prepare("SELECT * FROM products WHERE id=? LIMIT 1");
  $st->execute([$id]);
  $row = $st->fetch();
  if (!$row) { header("Location:/admin/products.php"); exit; }
  $product = $row;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $category_id = ($_POST['category_id'] ?? '') === '' ? null : (int)$_POST['category_id'];
  $name = trim($_POST['name'] ?? '');
  $slug = trim($_POST['slug'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $price = (float)($_POST['price'] ?? 0);
  $sale_raw = trim($_POST['sale_price'] ?? '');
  $sale_price = $sale_raw === '' ? null : (float)$sale_raw;
  $stock = (int)($_POST['stock'] ?? 0);
  $is_active = isset($_POST['is_active']) ? 1 : 0;

  if ($name === '') $errors[] = "Name is required";

  // ✅ AUTO SLUG: nếu để trống thì tự tạo từ name
  if ($slug === '') $slug = make_slug($name);

  // ✅ UNIQUE SLUG: chống trùng (edit thì bỏ qua chính nó)
  $slug = ensure_unique_product_slug($slug, $isEdit ? $id : 0);

  $thumbPath = $product['thumbnail'] ?? '';

  if (!empty($_FILES['thumbnail']['name'])) {
    if ($_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
      $tmp = $_FILES['thumbnail']['tmp_name'];
      $ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
      if (!in_array($ext, ['jpg','jpeg','png','webp'], true)) {
        $errors[] = "Thumbnail must be jpg/png/webp";
      } else {
        $dirAbs = __DIR__ . '/../uploads/products';
        if (!is_dir($dirAbs)) mkdir($dirAbs, 0775, true);
        $file = 'p_' . time() . '_' . random_int(1000,9999) . '.' . $ext;
        if (move_uploaded_file($tmp, $dirAbs . '/' . $file)) {
          $thumbPath = 'uploads/products/' . $file;
        } else $errors[] = "Upload failed";
      }
    } else $errors[] = "Upload error";
  }

  if (!$errors) {
    if ($isEdit) {
      $st = db()->prepare("
        UPDATE products SET
          category_id=?, name=?, slug=?, description=?,
          price=?, sale_price=?, stock=?, thumbnail=?, is_active=?
        WHERE id=? LIMIT 1
      ");
      $st->execute([$category_id,$name,$slug,$description,$price,$sale_price,$stock,$thumbPath,$is_active,$id]);
    } else {
      $st = db()->prepare("
        INSERT INTO products(category_id,name,slug,description,price,sale_price,stock,thumbnail,is_active)
        VALUES(?,?,?,?,?,?,?,?,?)
      ");
      $st->execute([$category_id,$name,$slug,$description,$price,$sale_price,$stock,$thumbPath,$is_active]);
    }
    header("Location:/admin/products.php"); exit;
  }

  $product = compact('category_id','name','slug','description','price','sale_price','stock','thumbPath','is_active');
  $product['thumbnail'] = $thumbPath;
}

$thumb = $product['thumbnail'] ?: 'uploads/placeholder.png';
?>
<div class="admin-content">
  <div class="admin-topbar d-flex justify-content-between align-items-center">
    <div>
      <div style="font-weight:900;font-size:18px;"><?= $isEdit ? 'Edit Product' : 'Add Product' ?></div>
      <div class="text-muted" style="font-size:12px;">Clean form. No bullshit.</div>
    </div>
    <a class="btn btn-outline-dark btn-sm btn-ceo" href="/admin/products.php">Back</a>
  </div>

  <div class="cardx mt-3 p-3">
    <?php if($errors): ?>
      <div class="alert alert-danger"><ul class="mb-0"><?php foreach($errors as $e) echo "<li>".e($e)."</li>"; ?></ul></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" value="<?= e($product['name'] ?? '') ?>" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Slug (optional)</label>
        <!-- ✅ bỏ required để admin khỏi phải nhập -->
        <input class="form-control" name="slug" value="<?= e($product['slug'] ?? '') ?>" placeholder="auto from name if empty">
      </div>

      <div class="col-md-6">
        <label class="form-label">Category</label>
        <select class="form-select" name="category_id">
          <option value="">-- None --</option>
          <?php foreach($cats as $c): ?>
            <option value="<?= (int)$c['id'] ?>" <?= ((int)($product['category_id'] ?? 0) === (int)$c['id']) ? 'selected':'' ?>>
              <?= e($c['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-2">
        <label class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" name="price" value="<?= e((string)($product['price'] ?? 0)) ?>">
      </div>

      <div class="col-md-2">
        <label class="form-label">Sale</label>
        <input type="number" step="0.01" class="form-control" name="sale_price" value="<?= e((string)($product['sale_price'] ?? '')) ?>">
      </div>

      <div class="col-md-2">
        <label class="form-label">Stock</label>
        <input type="number" class="form-control" name="stock" value="<?= e((string)($product['stock'] ?? 0)) ?>">
      </div>

      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="4"><?= e($product['description'] ?? '') ?></textarea>
      </div>

      <div class="col-md-6">
        <label class="form-label">Thumbnail</label>
        <input class="form-control" type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.webp">
        <div class="form-text">Uploads to /uploads/products/</div>
      </div>

      <div class="col-md-6 d-flex align-items-end justify-content-between">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?= ((int)($product['is_active'] ?? 1)===1) ? 'checked':'' ?>>
          <label class="form-check-label" for="is_active">Active</label>
        </div>
        <div class="d-flex align-items-center gap-2">
          <img src="/<?= e($thumb) ?>" style="width:72px;height:72px;object-fit:cover;border-radius:16px;border:1px solid #eee;">
        </div>
      </div>

      <div class="col-12 d-flex gap-2">
        <button class="btn btn-dark btn-ceo">Save</button>
        <a class="btn btn-outline-secondary btn-ceo" href="/admin/products.php">Cancel</a>
      </div>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
