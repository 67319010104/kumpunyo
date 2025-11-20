<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/functions.php';
if (!isset($_GET['id'])) { echo 'Missing id'; exit; }
$id = (int)$_GET['id'];
$stmt = $mysqli->prepare("SELECT p.*, s.shop_name FROM products p LEFT JOIN sellers s ON p.seller_id=s.id WHERE p.id=? LIMIT 1");
$stmt->bind_param('i',$id);
$stmt->execute();
$res = $stmt->get_result();
$p = $res->fetch_assoc();
if (!$p) { echo 'Not found'; exit; }
?>
<div>
  <div class="flex justify-between items-start">
    <h2 class="text-xl font-bold"><?php echo h($p['name']); ?></h2>
    <button onclick="closeQuickView()">ปิด</button>
  </div>
  <div class="mt-2">
    <img src="/online_store/assets/img/<?php echo h($p['image']?:'placeholder.png'); ?>" alt="" class="w-full h-64 object-cover rounded">
    <p class="mt-2 text-sm text-gray-600">ร้าน: <?php echo h($p['shop_name']); ?></p>
    <p class="mt-2"><?php echo nl2br(h($p['description'])); ?></p>
    <div class="mt-2 flex justify-between items-center">
      <div class="text-lg font-bold"><?php echo number_format($p['price'],2); ?> ฿</div>
      <form method="post" action="/online_store/add_to_cart.php">
        <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
        <input type="number" name="qty" value="1" min="1" class="w-20 border p-1 rounded">
        <button class="px-3 py-1 bg-primary text-white rounded">ใส่ตะกร้า</button>
      </form>
    </div>
  </div>
</div>
