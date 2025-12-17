<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';

$errors = [];
$name = '';
$slug = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'create') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    if ($name === '' || $slug === '') $errors[] = "Name and slug are required";

    if (!$errors) {
      $st = db()->prepare("INSERT INTO categories(name, slug) VALUES(?,?)");
      $st->execute([$name, $slug]);
      header("Location: /admin/categories.php"); exit;
    }
  }

  if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
      $st = db()->prepare("DELETE FROM categories WHERE id=? LIMIT 1");
      $st->execute([$id]);
    }
    header("Location: /admin/categories.php"); exit;
  }
}

$cats = db()->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();
?>
<div class="admin-content">
  <div class="admin-topbar d-flex justify-content-between align-items-center">
    <div>
      <div style="font-weight:900;font-size:18px;">Categories</div>
      <div class="text-muted" style="font-size:12px;">Manage product categories</div>
    </div>
  </div>

  <div class="row g-3 mt-1">
    <div class="col-md-4">
      <div class="cardx p-3">
        <div style="font-weight:900;" class="mb-2">Add Category</div>

        <?php if($errors): ?>
          <div class="alert alert-danger"><ul class="mb-0"><?php foreach($errors as $e) echo "<li>".e($e)."</li>"; ?></ul></div>
        <?php endif; ?>

        <form method="post" class="d-grid gap-2">
          <input type="hidden" name="action" value="create">
          <div>
            <label class="form-label">Name</label>
            <input class="form-control" name="name" value="<?= e($name) ?>" placeholder="Sneakers">
          </div>
          <div>
            <label class="form-label">Slug</label>
            <input class="form-control" name="slug" value="<?= e($slug) ?>" placeholder="sneakers">
          </div>
          <button class="btn btn-dark btn-ceo">Create</button>
        </form>
      </div>
    </div>

    <div class="col-md-8">
      <div class="cardx p-3">
        <div style="font-weight:900;" class="mb-2">All Categories</div>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead><tr><th>ID</th><th>Name</th><th>Slug</th><th class="text-end">Action</th></tr></thead>
            <tbody>
              <?php foreach($cats as $c): ?>
                <tr>
                  <td><?= (int)$c['id'] ?></td>
                  <td class="fw-semibold"><?= e($c['name']) ?></td>
                  <td class="text-muted"><?= e($c['slug']) ?></td>
                  <td class="text-end">
                    <form method="post" class="d-inline" onsubmit="return confirm('Delete this category?');">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                      <button class="btn btn-outline-danger btn-sm btn-ceo">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php if(!$cats): ?>
                <tr><td colspan="4" class="text-center text-muted py-4">No categories</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
