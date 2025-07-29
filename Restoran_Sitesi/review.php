<?php
require_once 'config/db.php';

$page_title = "Yorumlar";
$active_page = "review";

// Popüler ürünleri çek
$products = $db->query("SELECT * FROM products LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);

// TÜM yorumları çek (LIMIT 3 kaldırıldı)
$reviews = $db->query("SELECT * FROM reviews ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

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

    <!--! review section start  -->
<section class="review" id="review">
    <h1 class="heading">Müşteri <span>Yorumları</span></h1>
    
    <!-- Yorum Ekle Butonu -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <a href="add_review.php" class="btn">Yorum Ekle</a>
    </div>

    <div class="box-container">
        <?php foreach ($reviews as $review): ?>
        <div class="box">
            <img src="assets/images/<?= htmlspecialchars($review['user_image']) ?>" alt="quote" />
            <p><?= htmlspecialchars($review['comment']) ?></p>
            <h3><?= htmlspecialchars($review['user_name']) ?></h3>
            <div class="stars">
                <?= str_repeat('<i class="fas fa-star"></i>', $review['rating']) ?>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</section>
	<!--! review section end  -->

    <!--! footer section start  -->
    <?php include 'partials/footer.php'; ?>
    <!--! footer section end  -->

    <script src="assets/js/script.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>
