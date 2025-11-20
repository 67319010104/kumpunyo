<?php
require_once __DIR__ . '/inc/header.php';
$items = []; $total = 0.0;
if (is_logged_in()){
    $data = get_cart_items($_SESSION['user_id']);
    $items = $data['items'];
    $total = $data['total'];
} else {
    $cart = $_SESSION['cart'] ?? [];
    if ($cart){
        $ids = implode(',', array_map('intval', array_keys($cart)));
        $res = $mysqli->query("SELECT * FROM products WHERE id IN ($ids)");
        while($r = $res->fetch_assoc()){
            $r['qty'] = $cart[$r['id']];
            $r['subtotal'] = $r['qty'] * $r['price'];
            $total += $r['subtotal'];
            $items[] = $r;
        }
    }
}
?>
<h2 class="text-2xl font-semibold mb-4">ตะกร้าสินค้า</h2>
<?php if (empty($items)): ?>
  <p>ตะกร้าว่าง</p>
<?php else: ?>
  <div class="space-y-4">
    <?php foreach($items as $it): ?>
      <div class="bg-white p-4 rounded flex items-center justify-between">
        <div>
          <div class="font-semibold"><?php echo h($it['name']); ?></div>
          <div class="text-sm text-gray-500">ราคา <?php echo number_format($it['price'],2); ?> บาท x <?php echo $it['qty']; ?></div>
        </div>
        <div class="text-right">
          <div class="font-bold"><?php echo number_format($it['subtotal'],2); ?> ฿</div>
        </div>
      </div>
    <?php endforeach; ?>
    <div class="text-right font-bold">รวม <?php echo number_format($total,2); ?> ฿</div>
    <form method="post" action="/online_store/checkout.php">
      <button class="px-4 py-2 bg-primary text-white rounded">ชำระเงิน / สั่งซื้อ</button>
    </form>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
