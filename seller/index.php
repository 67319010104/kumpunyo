<?php
require_once __DIR__ . '/../inc/header.php';
$user = current_user();
if (!$user || $user['role'] !== 'seller') {
    echo '<div class="bg-white p-4 rounded">ต้องเป็นผู้ขายเท่านั้น</div>';
    require_once __DIR__ . '/../inc/footer.php';
    exit;
}
$seller = get_seller_by_user($user['id']);
if (!$seller){ echo '<div class="bg-white p-4 rounded">ไม่มีร้านค้าในระบบ</div>'; require_once __DIR__ . '/../inc/footer.php'; exit; }
$sid = $seller['id'];
// products for this seller
$stmt = $mysqli->prepare("SELECT * FROM products WHERE seller_id=? ORDER BY id DESC");
$stmt->bind_param('i',$sid);
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
// orders that include products from this seller (simple join)
$orders_stmt = $mysqli->prepare("SELECT DISTINCT o.* FROM orders o JOIN order_items oi ON oi.order_id=o.id JOIN products p ON p.id=oi.product_id WHERE p.seller_id=? ORDER BY o.id DESC");
$orders_stmt->bind_param('i',$sid);
$orders_stmt->execute();
$orders = $orders_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<h2 class="text-2xl font-semibold">แดชบอร์ดผู้ขาย — <?php echo h($seller['shop_name']); ?></h2>
<div class="mt-4">
  <a href="/online_store/seller/add_product.php" class="px-3 py-1 bg-primary text-white rounded">เพิ่มสินค้า</a>
  <a href="/online_store/seller/products.php" class="px-3 py-1 border rounded">จัดการสินค้า</a>
  <a href="/online_store/seller/orders.php" class="px-3 py-1 border rounded">คำสั่งซื้อของร้าน</a>
</div>

<h3 class="mt-6 font-semibold">สินค้าของคุณ</h3>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
<?php foreach($products as $p): ?>
  <div class="bg-white p-3 rounded shadow">
    <div class="font-semibold"><?php echo h($p['name']); ?></div>
    <div class="text-sm"><?php echo number_format($p['price'],2); ?> ฿ — สถานะ: <?php echo h($p['status']); ?></div>
  </div>
<?php endforeach; ?>
</div>

<h3 class="mt-6 font-semibold">คำสั่งซื้อที่เกี่ยวข้อง</h3>
<ul class="space-y-3 mt-2">
<?php foreach($orders as $o): ?>
  <li class="bg-white p-3 rounded shadow">#<?php echo h($o['id']); ?> — <?php echo number_format($o['total'],2); ?> ฿ — <?php echo h($o['status']); ?></li>
<?php endforeach; ?>
</ul>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>
