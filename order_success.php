<?php
require_once __DIR__ . '/inc/header.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>
<div class="bg-white p-6 rounded shadow">
  <h2 class="text-2xl font-semibold">สั่งซื้อสำเร็จ</h2>
  <p>เลขที่คำสั่งซื้อ: <?php echo $id; ?></p>
  <a href="/online_store/" class="text-primary">กลับไปหน้าแรก</a>
</div>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
