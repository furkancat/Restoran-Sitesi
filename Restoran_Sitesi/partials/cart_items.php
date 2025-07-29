<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="cart-items">
    <?php if (empty($_SESSION['cart'])): ?>
        <p class="empty-cart">Sepetiniz boş</p>
    <?php else: ?>
        <?php 
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $item): 
            $total += $item['price'] * $item['quantity'];
        ?>
            <div class="cart-item">
                <i class="fas fa-times remove-item" data-id="<?= $id ?>"></i>
                <img src="assets/images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" />
                <div class="content">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <div class="price">₺<?= number_format($item['price'], 2) ?></div>
                    <div class="quantity">
                        <button class="quantity-btn minus" data-id="<?= $id ?>">-</button>
                        <span><?= $item['quantity'] ?></span>
                        <button class="quantity-btn plus" data-id="<?= $id ?>">+</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="cart-total">Toplam: ₺<?= number_format($total, 2) ?></div>

<!-- Ödemeye geç butonu -->
<div class="checkout-button">
    <a href="checkout.php" class="btn-checkout">Ödemeye Geç</a>
</div>
    <?php endif; ?>
</div>