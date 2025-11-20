<?php
require_once __DIR__ . '/inc/header.php';
$stmt = $mysqli->query("SELECT p.*, s.shop_name FROM products p LEFT JOIN sellers s ON p.seller_id=s.id WHERE p.status='approved' ORDER BY p.created_at DESC LIMIT 30");
$products = $stmt->fetch_all(MYSQLI_ASSOC);
?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
<?php foreach($products as $p): ?>
  <div class="bg-white p-4 rounded shadow">
    <img src="./assets/img/<?php echo h($p['image'] ?? 'placeholder.png'); ?>" 
     alt="<?php echo h($p['name']); ?>" 
     class="w-full h-48 object-cover rounded block bg-gray-100">
    <h3 class="mt-2 font-semibold"><?php echo h($p['name']); ?></h3>
    <p class="text-sm text-gray-500"><?php echo h($p['shop_name']); ?></p>
    <div class="mt-2 flex items-center justify-between">
      <div class="text-lg font-bold"><?php echo number_format($p['price'],2); ?> ฿</div>
      <div>
        <button onclick="openQuickView(<?php echo $p['id']; ?>)" class="px-3 py-1 border rounded">Quick view</button>
        <form method="post" action="/online_store/add_to_cart.php" class="inline">
          <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
          <button class="px-3 py-1 bg-primary text-white rounded">ใส่ตะกร้า</button>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<!-- Quick view modal (simple) -->
<div id="quickViewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
  <div class="bg-white rounded shadow max-w-2xl w-full p-4" id="quickViewContent"></div>
</div>

<script>
function openQuickView(id){
  fetch('/online_store/quick_view.php?id='+id).then(r=>r.text()).then(html=>{
    document.getElementById('quickViewContent').innerHTML = html;
    document.getElementById('quickViewModal').classList.remove('hidden');
    document.getElementById('quickViewModal').classList.add('flex');
  });
}
function closeQuickView(){
  document.getElementById('quickViewModal').classList.add('hidden');
  document.getElementById('quickViewModal').classList.remove('flex');
}
</script>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
