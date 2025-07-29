<?php
require_once 'config/db.php';

$page_title = "Menü";
$active_page = "menu";

// Tüm ürünleri çek
$products = $db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
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

    <!--! menu section start  -->
    <section class="menu" id="menu">
        <h1 class="heading">Tüm <span>Menüler</span></h1>
        <div class="box-container">
            <?php foreach ($products as $product): ?>
            <div class="box">
                <div class="box-head">
                    <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                    <span class="menu-category">
                        <?php 
                        $category = $db->query("SELECT name FROM categories WHERE id = " . $product['category_id'])->fetchColumn();
                        echo htmlspecialchars($category);
                        ?>
                    </span>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <div class="price">₺<?php echo number_format($product['price'], 2); ?> <span>₺<?php echo number_format($product['price'] * 1.2, 2); ?></span></div>
                </div>
                <div class="box-bottom">
                    <a href="#" class="btn add-to-cart" data-id="<?php echo $product['id']; ?>">sepete ekle</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <!--! menu section end  -->

    <!--! footer section start  -->
    <?php include 'partials/footer.php'; ?>
    <!--! footer section end  -->

    <script src="assets/js/script.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>