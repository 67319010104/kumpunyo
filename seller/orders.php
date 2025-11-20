<?php
require_once __DIR__ . '/../inc/header.php';
$user = current_user();
if (!$user || $user['role'] !== 'seller') { echo 'Forbidden'; exit; }
$seller = get_seller_by_user($user['id']);
$sid = $seller['id'];
$stmt = $mysqli->prepare("SELECT DISTINCT o.* FROM orders o JOIN order_items oi ON oi.order_id=o.id JOIN products p ON p.id=oi.product_id WHERE p.seller_id=? ORDER BY o.id DESC");
$stmt->bind_param('i',$sid);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<h2 class="text-2xl font-semibold">คำสั่งซื้อของร้าน <?php echo h($seller['shop_name']); ?></h2>
<ul class="space-y-3 mt-2">
<?php foreach($orders as $o): ?>
  <li class="bg-white p-3 rounded shadow">#<?php echo h($o['id']); ?> — <?php echo number_format($o['total'],2); ?> ฿ — <?php echo h($o['status']); ?></li>
<?php endforeach; ?>
</ul>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
