<?php
// inc/functions.php
require_once __DIR__ . '/config.php';

function is_logged_in(){
    return isset($_SESSION['user_id']);
}
function current_user(){
    global $mysqli;
    if (!is_logged_in()) return null;
    $id = (int)$_SESSION['user_id'];
    $stmt = $mysqli->prepare("SELECT id,name,email,role FROM users WHERE id=? LIMIT 1");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc();
}
function require_login(){
    if (!is_logged_in()){
        header('Location: /online_store/login.php');
        exit;
    }
}
function require_role($role){
    $user = current_user();
    if (!$user || $user['role'] !== $role){
        http_response_code(403);
        echo 'Forbidden';
        exit;
    }
}
function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

// Seller helper
function get_seller_by_user($user_id){
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM sellers WHERE user_id=? LIMIT 1");
    $stmt->bind_param('i',$user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Cart helpers (DB-backed for logged-in users; sessions still work for guests)
function add_to_cart($user_id, $product_id, $qty=1){
    global $mysqli;
    // insert or update
    $stmt = $mysqli->prepare("INSERT INTO cart (user_id,product_id,qty) VALUES (?,?,?) ON DUPLICATE KEY UPDATE qty=qty+VALUES(qty)");
    $stmt->bind_param('iii',$user_id,$product_id,$qty);
    return $stmt->execute();
}
function get_cart_items($user_id){
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT c.qty, p.* FROM cart c JOIN products p ON c.product_id=p.id WHERE c.user_id=?");
    $stmt->bind_param('i',$user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $items = [];
    $total = 0;
    while($r = $res->fetch_assoc()){
        $r['subtotal'] = $r['qty'] * $r['price'];
        $items[] = $r;
        $total += $r['subtotal'];
    }
    return ['items'=>$items,'total'=>$total];
}
function clear_cart($user_id){
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM cart WHERE user_id=?");
    $stmt->bind_param('i',$user_id);
    return $stmt->execute();
}
?>
