<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';

$errors = [];
$title = '';
$subtitle = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  // ===== ADD COLLECTION =====
  if ($action === 'create') {
    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');

    if ($title === '' || $subtitle === '') {
      $errors[] = 'Vui lòng nhập đầy đủ thông tin';
    }

    // upload image
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
      $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
      $imageName = time() . '_' . rand(1000,9999) . '.' . $ext;
      $path = __DIR__ . '/../uploads/collections/' . $imageName;

      if (!move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
        $errors[] = 'Upload ảnh thất bại';
      }
    }

    if (!$errors) {
      $st = db()->prepare("INSERT INTO collections(title, subtitle, image) VALUES(?,?,?)");
      $st->execute([$title, $subtitle, $imageName]);
      header('Location: collections.php');
      exit;
    }
  }

  // ===== DELETE =====
  if ($action === 'delete') {
    $id = (int)$_POST['id'];
    if ($id > 0) {
      db()->prepare("DELETE FROM collections WHERE id=?")->execute([$id]);
    }
    header('Location: collections.php');
    exit;
  }
}

$collections = db()->query("SELECT * FROM collections ORDER BY id DESC")->fetchAll();
?>

<div class="cardx p-3">
  <h5>Thêm Collection</h5>

  <?php if($errors): ?>
    <div class="alert alert-danger">
      <?php foreach($errors as $e) echo "<div>".e($e)."</div>"; ?>
    </div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" class="d-grid gap-2">
    <input type="hidden" name="action" value="create">

    <input class="form-control" name="title" placeholder="Tên collection">
    <input class="form-control" name="subtitle" placeholder="Mô tả ngắn">

    <input type="file" class="form-control" name="image" accept="image/*">

    <button class="btn btn-dark">Thêm collection</button>
  </form>
</div>

<div class="cardx p-3 mt-3">
  <h5>Danh sách Collections</h5>

  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Ảnh</th>
        <th>Tiêu đề</th>
        <th>Mô tả</th>
        <th>Ngày</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($collections as $c): ?>
        <tr>
          <td><?= $c['id'] ?></td>
          <td>
            <?php if($c['image']): ?>
              <img src="/uploads/collections/<?= e($c['image']) ?>" style="width:60px;border-radius:6px">
            <?php endif; ?>
          </td>
          <td><?= e($c['title']) ?></td>
          <td><?= e($c['subtitle']) ?></td>
          <td><?= $c['created_at'] ?></td>
          <td>
            <form method="post" onsubmit="return confirm('Xoá collection?')">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= $c['id'] ?>">
              <button class="btn btn-sm btn-danger">Xoá</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>