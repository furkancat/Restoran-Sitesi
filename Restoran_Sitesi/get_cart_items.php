<?php
require_once 'config/db.php';

$cartItems = $_SESSION['cart'] ?? [];
$total = 0;
?>

<?php foreach ($cartItems as $item): ?>
<div class="cart-item">
    <i class="fas fa-times remove-item" data-id="<?php echo $item['id']; ?>"></i>
    <img src="assets/images/products/product-<?php echo $item['id']; ?>.png" alt="<?php echo htmlspecialchars($item['name']); ?>" />
    <div class="content">
        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
        <div class="price">$<?php echo number_format($item['price'], 2); ?>/-</div>
        <div class="quantity">Adet: <?php echo $item['quantity']; ?></div>
    </div>
</div>
<?php 
    $total += $item['price'] * $item['quantity'];
endforeach; 
?>

<?php if (empty($cartItems)): ?>
<p class="empty-cart">Sepetiniz boş</p>
<?php endif; ?>