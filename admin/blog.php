<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';

$errors = [];
$title = '';
$slug = '';
$content = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  // ===== ADD BLOG =====
  if ($action === 'create') {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $slug === '' || $content === '') {
      $errors[] = 'Vui lòng nhập đầy đủ thông tin';
    }

    // upload image
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
      $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
      $imageName = time() . '_' . rand(1000,9999) . '.' . $ext;
      $path = __DIR__ . '/../uploads/blogs/' . $imageName;

      if (!move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
        $errors[] = 'Upload ảnh thất bại';
      }
    }

    if (!$errors) {
      $st = db()->prepare("INSERT INTO blogs(title, slug, image, content) VALUES(?,?,?,?)");
      $st->execute([$title, $slug, $imageName, $content]);
      header('Location: blog.php');
      exit;
    }
  }

  // ===== DELETE =====
  if ($action === 'delete') {
    $id = (int)$_POST['id'];
    if ($id > 0) {
      db()->prepare("DELETE FROM blogs WHERE id=?")->execute([$id]);
    }
    header('Location: blog.php');
    exit;
  }
}

$blogs = db()->query("SELECT * FROM blogs ORDER BY id DESC")->fetchAll();
?>

<div class="cardx p-3">
  <h5>Thêm Blog</h5>

  <?php if($errors): ?>
    <div class="alert alert-danger">
      <?php foreach($errors as $e) echo "<div>".e($e)."</div>"; ?>
    </div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" class="d-grid gap-2">
    <input type="hidden" name="action" value="create">

    <input class="form-control" name="title" placeholder="Tiêu đề blog">
    <input class="form-control" name="slug" placeholder="slug-blog">

    <input type="file" class="form-control" name="image" accept="image/*">

    <textarea class="form-control" name="content" rows="5" placeholder="Nội dung blog"></textarea>

    <button class="btn btn-dark">Đăng blog</button>
  </form>
</div>

<div class="cardx p-3 mt-3">
  <h5>Danh sách Blog</h5>

  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Ảnh</th>
        <th>Tiêu đề</th>
        <th>Ngày</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($blogs as $b): ?>
        <tr>
          <td><?= $b['id'] ?></td>
          <td>
            <?php if($b['image']): ?>
              <img src="/uploads/blogs/<?= e($b['image']) ?>" style="width:60px;border-radius:6px">
            <?php endif; ?>
          </td>
          <td><?= e($b['title']) ?></td>
          <td><?= $b['created_at'] ?></td>
          <td>
            <form method="post" onsubmit="return confirm('Xoá blog?')">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= $b['id'] ?>">
              <button class="btn btn-sm btn-danger">Xoá</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
