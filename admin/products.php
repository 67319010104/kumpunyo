<?php
require_once __DIR__ . '/../inc/header.php';
if (!current_user() || current_user()['role'] !== 'admin'){ echo 'Forbidden'; exit; }

// handle approve action
if (isset($_GET['approve_id'])){
    $aid = (int)$_GET['approve_id'];
    $stmt = $mysqli->prepare("UPDATE products SET status='approved' WHERE id=?");
    $stmt->bind_param('i',$aid);
    $stmt->execute();
    header('Location: /online_store/admin/products.php');
    exit;
}

$res = $mysqli->query("SELECT p.*, u.name AS seller_user, s.shop_name FROM products p LEFT JOIN sellers s ON p.seller_id=s.id LEFT JOIN users u ON s.user_id=u.id ORDER BY p.id DESC");
?>
<h2 class="text-2xl font-semibold">จัดการสินค้า (Admin)</h2>
<div class="grid grid-cols-1 gap-4 mt-4">
<?php while($p = $res->fetch_assoc()): ?>
  <div class="bg-white p-3 rounded shadow">
    <div class="font-semibold"><?php echo h($p['name']); ?></div>
    <div class="text-sm">ร้าน: <?php echo h($p['shop_name']); ?> — สถานะ: <?php echo h($p['status']); ?></div>
    <?php if ($p['status'] === 'pending'): ?>
      <a href="/online_store/admin/products.php?approve_id=<?php echo $p['id']; ?>" class="px-3 py-1 bg-primary text-white rounded">อนุมัติ</a>
    <?php endif; ?>
  </div>
<?php endwhile; ?>
</div>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
