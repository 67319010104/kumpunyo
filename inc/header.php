<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
$user = current_user();
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo h($site_name); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { font-family: 'Kanit', sans-serif; }
    .primary { color: <?php echo $primary_color; ?>; }
    .bg-primary { background-color: <?php echo $primary_color; ?>; }
  </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

  <header class="bg-white shadow-sm">
    <div class="max-w-6xl mx-auto flex items-center justify-between p-4">
      
      <a href="/online_store/" class="text-xl font-semibold primary"><?php echo h($site_name); ?></a>
      
      <nav class="space-x-4">
        <a href="/online_store/" class="hover:underline">หน้าแรก</a>
        <?php if ($user): ?>
          <?php if ($user['role']==='seller'): ?>
            <a href="/online_store/seller/" class="hover:underline">แดชบอร์ดผู้ขาย</a>
          <?php endif; ?>
          <?php if ($user['role']==='admin'): ?>
            <a href="/online_store/admin/" class="hover:underline">แผงผู้ดูแล</a>
          <?php endif; ?>
          <a href="/online_store/cart.php" class="hover:underline">ตะกร้า</a>
          <a href="/online_store/logout.php" class="hover:underline">ออกจากระบบ (<?php echo h($user['name']); ?>)</a>
        <?php else: ?>
          <a href="/online_store/login.php" class="hover:underline">เข้าสู่ระบบ</a>
          <a href="/online_store/register.php" class="hover:underline">สมัครสมาชิก</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="max-w-6xl mx-auto p-4 flex-grow w-full">