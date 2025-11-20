<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/functions.php';
if (!is_logged_in()){
    header('Location: /online_store/login.php');
    exit;
}
$uid = (int)$_SESSION['user_id'];
// fetch cart items
$data = get_cart_items($uid);
$items = $data['items'];
$total = $data['total'];
if (empty($items)){
    header('Location: /online_store/cart.php');
    exit;
}
// create order
$stmt = $mysqli->prepare("INSERT INTO orders (user_id,total,status) VALUES (?,?, 'pending')");
$stmt->bind_param('id',$uid,$total);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();
// insert items and reduce stock
$stmt = $mysqli->prepare("INSERT INTO order_items (order_id,product_id,qty,price) VALUES (?,?,?,?)");
$upd = $mysqli->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
foreach($items as $p){
    $stmt->bind_param('iiid',$order_id,$p['id'],$p['qty'],$p['price']);
    $stmt->execute();
    $upd->bind_param('ii',$p['qty'],$p['id']);
    $upd->execute();
}
$stmt->close();
$upd->close();
// clear cart
clear_cart($uid);
header('Location: /online_store/order_success.php?id='.$order_id);
exit;
