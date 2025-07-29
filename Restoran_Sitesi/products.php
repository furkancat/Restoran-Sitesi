<?php
require_once 'config/db.php';

$page_title = "Ürünlerimiz";
$active_page = "products";

// Kategori filtresi
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Ürünleri çek
if ($category_id > 0) {
    $stmt = $db->prepare("SELECT * FROM products WHERE category_id = ?");
    $stmt->execute([$category_id]);
} else {
    $stmt = $db->query("SELECT * FROM products");
}
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kategorileri çek
$categories = $db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title><?php echo $page_title; ?> | Restaurant Web Site</title>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <!--! header section start  -->
    <?php include 'partials/header.php'; ?>
    <!--! header section end  -->

    <!--! products section start  -->
    <section class="products" id="products">
        <h1 class="heading">Ürünlerimiz <span>Menü</span></h1>
        
        <!-- Kategori filtreleri -->
        <div class="category-filters">
            <a href="products.php" class="<?php echo $category_id == 0 ? 'active' : ''; ?>">Tümü</a>
            <?php foreach ($categories as $category): ?>
                <a href="products.php?category=<?php echo $category['id']; ?>" 
                   class="<?php echo $category_id == $category['id'] ? 'active' : ''; ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <div class="box-container">
            <?php if (empty($products)): ?>
                <p class="empty">Bu kategoride ürün bulunamadı.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                <div class="box">
                    <div class="box-head">
                        <span class="title">
                            <?php 
                            $category = $db->query("SELECT name FROM categories WHERE id = " . $product['category_id'])->fetchColumn();
                            echo htmlspecialchars($category);
                            ?>
                        </span>
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="name">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </a>
                    </div>
                    <div class="image">
                        <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                    </div>
                    <div class="box-bottom">
                        <div class="info">
                            <b class="price">₺<?php echo number_format($product['price'], 2); ?></b>
                            <span class="amount"><?php echo htmlspecialchars($product['calories']); ?></span>
                        </div>
                        <div class="product-btn">
                            <a href="#" class="add-to-cart" data-id="<?php echo $product['id']; ?>">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
    <!--! products section end  -->

    <!--! footer section start  -->
    <?php include 'partials/footer.php'; ?>
    <!--! footer section end  -->

    <script src="assets/js/script.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>