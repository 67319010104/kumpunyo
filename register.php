<?php
require_once __DIR__ . '/inc/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = in_array($_POST['role'] ?? 'user',['user','seller']) ? $_POST['role'] : 'user';
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss',$name,$email,$hash,$role);
    if ($stmt->execute()){
        // if seller, create empty shop
        $uid = $stmt->insert_id;
        if ($role === 'seller'){
            $s = $mysqli->prepare("INSERT INTO shops (user_id,name) VALUES (?,?)");
            $shopname = $name . ' ร้าน';
            $s->bind_param('is',$uid,$shopname);
            $s->execute();
            $s->close();
        }
        header('Location: /online_store/login.php');
        exit;
    } else {
        $error = $mysqli->error;
    }
}
require_once __DIR__ . '/inc/header.php';
?>
<h2 class="text-2xl font-semibold mb-4">สมัครสมาชิก</h2>
<?php if (!empty($error)): ?><div class="text-red-600"><?php echo h($error); ?></div><?php endif; ?>
<form method="post" class="space-y-3 bg-white p-4 rounded">
  <input name="name" placeholder="ชื่อ" class="w-full border p-2 rounded" required>
  <input name="email" type="email" placeholder="อีเมล" class="w-full border p-2 rounded" required>
  <input name="password" type="password" placeholder="รหัสผ่าน" class="w-full border p-2 rounded" required>
  <select name="role" class="w-full border p-2 rounded">
    <option value="user">ผู้ใช้ทั่วไป</option>
    <option value="seller">ผู้ขาย</option>
  </select>
  <button class="px-4 py-2 bg-primary text-white rounded">สมัคร</button>
</form>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
