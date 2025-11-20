<?php
require_once __DIR__ . '/../inc/header.php';
$user = current_user();
if (!$user || $user['role'] !== 'admin') {
    echo '<div class="bg-white p-4 rounded">ต้องเป็นผู้ดูแลระบบเท่านั้น</div>';
    require_once __DIR__ . '/../inc/footer.php';
    exit;
}
?>
<h2 class="text-2xl font-semibold">แผงผู้ดูแล (Admin)</h2>
<div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
  <a href="/online_store/admin/users.php" class="bg-white p-4 rounded shadow">จัดการผู้ใช้</a>
  <a href="/online_store/admin/products.php" class="bg-white p-4 rounded shadow">จัดการสินค้า</a>
  <a href="/online_store/admin/orders.php" class="bg-white p-4 rounded shadow">จัดการคำสั่งซื้อ</a>
</div>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
