<?php
require_once __DIR__ . '/../inc/header.php';
if (!current_user() || current_user()['role'] !== 'admin'){ echo 'Forbidden'; exit; }
$res = $mysqli->query("SELECT o.*, u.name AS customer FROM orders o LEFT JOIN users u ON o.user_id=u.id ORDER BY o.id DESC");
?>
<h2 class="text-2xl font-semibold">คำสั่งซื้อ</h2>
<ul class="space-y-3">
<?php while($o = $res->fetch_assoc()): ?>
  <li class="bg-white p-3 rounded shadow">
    <div>#<?php echo h($o['id']); ?> — <?php echo h($o['customer']); ?> — <?php echo number_format($o['total'],2); ?> ฿ — <?php echo h($o['status']); ?></div>
  </li>
<?php endwhile; ?>
</ul>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
