<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';

$users = db()->query("
  SELECT id, full_name, email, phone, role, status, created_at
  FROM users
  ORDER BY id DESC
  LIMIT 300
")->fetchAll();
?>
<div class="admin-content">
  <div class="admin-topbar d-flex justify-content-between align-items-center">
    <div>
      <div style="font-weight:900;font-size:18px;">Users</div>
      <div class="text-muted" style="font-size:12px;">Read-only list</div>
    </div>
  </div>

  <div class="cardx mt-3 p-3">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th>Created</th></tr></thead>
        <tbody>
          <?php foreach($users as $u): ?>
            <tr>
              <td><?= (int)$u['id'] ?></td>
              <td class="fw-semibold"><?= e($u['full_name']) ?></td>
              <td><?= e($u['email']) ?></td>
              <td><?= e($u['phone'] ?? '-') ?></td>
              <td><?= e($u['role']) ?></td>
              <td><?= ((int)$u['status']===1) ? '<span class="pill ok">Active</span>' : '<span class="pill no">Off</span>' ?></td>
              <td class="text-muted" style="font-size:12px;"><?= e($u['created_at']) ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if(!$users): ?>
            <tr><td colspan="7" class="text-center text-muted py-4">No users</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
