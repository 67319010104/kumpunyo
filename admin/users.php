<?php
require_once __DIR__ . '/../inc/header.php';
if (!current_user() || current_user()['role'] !== 'admin'){ echo 'Forbidden'; exit; }
$res = $mysqli->query("SELECT id,name,email,role,created_at FROM users ORDER BY id DESC");
?>
<h2 class="text-2xl font-semibold">ผู้ใช้</h2>
<a href="/online_store/admin/sellers.php" class="px-3 py-1 border rounded">ดูผู้ขาย</a>
<table class="min-w-full bg-white mt-4">
  <thead><tr><th>ID</th><th>ชื่อ</th><th>อีเมล</th><th>บทบาท</th><th>วันที่</th></tr></thead>
  <tbody>
  <?php while($r = $res->fetch_assoc()): ?>
    <tr>
      <td><?php echo h($r['id']); ?></td>
      <td><?php echo h($r['name']); ?></td>
      <td><?php echo h($r['email']); ?></td>
      <td><?php echo h($r['role']); ?></td>
      <td><?php echo h($r['created_at']); ?></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
