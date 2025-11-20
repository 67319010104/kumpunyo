<?php
require_once __DIR__ . '/inc/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = $mysqli->prepare("SELECT id,password,role,name FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $res = $stmt->get_result();
    $u = $res->fetch_assoc();
    if ($u && password_verify($password, $u['password'])){
        $_SESSION['user_id'] = $u['id'];
        header('Location: /online_store/');
        exit;
    } else {
        $error = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
    }
}
require_once __DIR__ . '/inc/header.php';
?>
<h2 class="text-2xl font-semibold mb-4">เข้าสู่ระบบ</h2>
<?php if (!empty($error)): ?><div class="text-red-600"><?php echo h($error); ?></div><?php endif; ?>
<form method="post" class="space-y-3 bg-white p-4 rounded">
  <input name="email" type="email" placeholder="อีเมล" class="w-full border p-2 rounded" required>
  <input name="password" type="password" placeholder="รหัสผ่าน" class="w-full border p-2 rounded" required>
  <button class="px-4 py-2 bg-primary text-white rounded">เข้าสู่ระบบ</button>
</form>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
