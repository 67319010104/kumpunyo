<?php
require_once __DIR__ . '/../inc/header.php';
$user = current_user();
if (!$user || $user['role'] !== 'seller') { echo 'Forbidden'; exit; }
$seller = get_seller_by_user($user['id']);
if (!$seller){ echo 'No shop'; exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name']; $desc = $_POST['description']; $price = (float)$_POST['price']; $stock = (int)$_POST['stock'];
    $img = $_POST['image'] ?: 'placeholder.png';
    $s = $mysqli->prepare("INSERT INTO products (seller_id,name,description,price,stock,image,status) VALUES (?,?,?,?,?,?, 'pending')");
    $s->bind_param('issdis',$seller['id'],$name,$desc,$price,$stock,$img);
    if ($s->execute()){
        header('Location: /online_store/seller/');
        exit;
    } else {
        $error = $mysqli->error;
    }
}
?>
<h2 class="text-2xl font-semibold">เพิ่มสินค้า (รอการอนุมัติ)</h2>
<?php if (!empty($error)): ?><div class="text-red-600"><?php echo h($error); ?></div><?php endif; ?>
<form method="post" class="bg-white p-4 rounded space-y-3">
  <input name="name" placeholder="ชื่อสินค้า" class="w-full border p-2 rounded" required>
  <textarea name="description" placeholder="คำอธิบาย" class="w-full border p-2 rounded"></textarea>
  <input name="price" placeholder="ราคา" class="w-full border p-2 rounded" required>
  <input name="stock" placeholder="สต็อก" class="w-full border p-2 rounded" required>
  <input name="image" placeholder="ชื่อไฟล์รูป (เก็บใน assets/img/)" class="w-full border p-2 rounded">
  <button class="px-4 py-2 bg-primary text-white rounded">ส่งเพื่อขออนุมัติ</button>
</form>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
