<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = (int)($_POST['product_id'] ?? 0);
    $qty = max(1, (int)($_POST['qty'] ?? 1));
    if (!$pid) { header('Location: /online_store/'); exit; }
    if (is_logged_in()){
        $uid = (int)$_SESSION['user_id'];
        add_to_cart($uid, $pid, $qty);
        header('Location: /online_store/cart.php');
        exit;
    } else {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        if (!isset($_SESSION['cart'][$pid])) $_SESSION['cart'][$pid] = 0;
        $_SESSION['cart'][$pid] += $qty;
        header('Location: /online_store/cart.php');
        exit;
    }
}
header('Location: /online_store/');
