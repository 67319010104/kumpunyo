<?php
require_once __DIR__ . '/../inc/header.php';
$user = current_user();
if (!$user || $user['role'] !== 'seller') { echo 'Forbidden'; exit; }
$seller = get_seller_by_user($user['id']);
if (!$seller) { echo 'No shop'; exit; }
$sid = $seller['id'];
$stmt = $mysqli->prepare("SELECT * FROM products WHERE seller_id=? ORDER BY id DESC");
$stmt->bind_param('i',$sid);
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<h2 class="text-2xl font-semibold">จัดการสินค้า — <?php echo h($seller['shop_name']); ?></h2>
<a href="/online_store/seller/add_product.php" class="px-3 py-1 bg-primary text-white rounded">เพิ่มสินค้า</a>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
<?php foreach($products as $p): ?>
  <div class="bg-white p-3 rounded shadow">
    <div class="font-semibold"><?php echo h($p['name']); ?></div>
    <div class="text-sm">ราคา <?php echo number_format($p['price'],2); ?> ฿ — สต็อก: <?php echo h($p['stock']); ?> — สถานะ: <?php echo h($p['status']); ?></div>
  </div>
<?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
