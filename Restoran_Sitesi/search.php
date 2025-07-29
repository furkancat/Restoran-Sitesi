<?php
require_once 'config/db.php';

$page_title = "Arama Sonuçları";
$active_page = "search";

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

$results = [];
if (!empty($query)) {
    $stmt = $db->prepare("SELECT * FROM products WHERE name LIKE :q OR description LIKE :q");
    $stmt->execute(['q' => "%$query%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $page_title; ?> | Restaurant Web Site</title>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <section class="search-results">
        <h1 class="heading">Arama Sonuçları <span>"<?php echo htmlspecialchars($query); ?>"</span></h1>

        <div class="box-container">
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $product): ?>
                    <div class="box">
                        <img src="assets/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p><?php echo $product['description']; ?></p>
                        <div class="price"><?php echo number_format($product['price'], 2); ?> ₺</div>
                        <button class="btn add-to-cart" data-id="<?php echo $product['id']; ?>">Sepete Ekle</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aradığınız kelimeyle eşleşen ürün bulunamadı.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'partials/footer.php'; ?>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>
