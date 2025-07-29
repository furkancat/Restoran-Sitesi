<?php
require_once 'config/db.php';

$page_title = "Anasayfa";
$active_page = "home";

// Popüler ürünleri çek
$products = $db->query("SELECT * FROM products LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);

// Son yorumları çek
$reviews = $db->query("SELECT * FROM reviews ORDER BY created_at DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

// Son blog yazılarını çek
$blogs = $db->query("SELECT * FROM blogs ORDER BY publish_date DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
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

    <!--! home section start  -->
    <section class="home" id="home">
        <div class="content">
            <h3>EVE HIZLI TESLİMAT</h3>
            <p>
               Restorantımıza Hoş Geldiniz Lezzetlerimizi Denemek İster Misiniz?
            </p>
            <a href="products.php" class="btn">Sipariş Ver</a>
        </div>
    </section>
    <!--! home section end  -->

    <!--! menu section start  -->
    <section class="menu" id="menu">
        <h1 class="heading">Popüler <span>Menüler</span></h1>
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

    <!--! review section start  -->
    <section class="review" id="review">
        <h1 class="heading">Müşteri <span>Yorumları</span></h1>
        <div class="box-container">
            <?php foreach ($reviews as $review): ?>
            <div class="box">
                <img src="assets/images/<?php echo htmlspecialchars($review['user_image']); ?>" alt="quote" />
                <p><?php echo htmlspecialchars($review['comment']); ?></p>
                <h3><?php echo htmlspecialchars($review['user_name']); ?></h3>
                <div class="stars">
                    <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                        <i class="fas fa-star"></i>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <!--! review section end  -->

    <!--! blogs section start  -->
    <section class="blogs" id="blogs">
        <h1 class="heading">Son <span>Blog Yazıları</span></h1>
        <div class="box-container">
            <?php foreach ($blogs as $blog): ?>
            <div class="box">
                <div class="image">
                    <img src="assets/images/<?php echo htmlspecialchars($blog['image']); ?>" alt="blog" />
                </div>
                <div class="content">
                    <a href="blog_detail.php?id=<?php echo $blog['id']; ?>" class="title"><?php echo htmlspecialchars($blog['title']); ?></a>
                    <span><?php echo htmlspecialchars($blog['author']); ?> / <?php echo date('d M, Y', strtotime($blog['publish_date'])); ?></span>
                    <p><?php echo substr(htmlspecialchars($blog['content']), 0, 100); ?>...</p>
                    <a href="blog_detail.php?id=<?php echo $blog['id']; ?>" class="btn">devamını oku</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <!--! blogs section end  -->

    <!--! footer section start  -->
    <?php include 'partials/footer.php'; ?>
    <!--! footer section end  -->

    <script src="assets/js/script.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>