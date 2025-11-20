<?php
require_once __DIR__ . '/../inc/header.php';
if (!current_user() || current_user()['role'] !== 'admin'){ echo 'Forbidden'; exit; }
$res = $mysqli->query("SELECT s.*, u.email FROM sellers s JOIN users u ON s.user_id=u.id ORDER BY s.id DESC");
?>
<h2 class="text-2xl font-semibold">จัดการผู้ขาย (Sellers)</h2>
<table class="min-w-full bg-white mt-4">
<thead><tr><th>ID</th><th>ร้าน</th><th>ผู้ใช้ (อีเมล)</th><th>วันที่</th></tr></thead>
<tbody>
<?php while($r = $res->fetch_assoc()): ?>
<tr>
  <td><?php echo h($r['id']); ?></td>
  <td><?php echo h($r['shop_name']); ?></td>
  <td><?php echo h($r['email']); ?></td>
  <td><?php echo h($r['created_at']); ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
