<?php
require_once 'config/db.php';

$page_title = "Anasayfa";
$active_page = "about";

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

    <!--! about section start  -->
    <section class="about" id="about">
      <h1 class="heading">Hakkımızda</h1>
      <div class="row">
        <div class="image">
          <img src="assets/images/about.jpg" alt="about" />
        </div>
        <div class="content">
          <h3>Burgerlerimizin Gizli Tarifi Nedir?</h3>
          <p>
            Uzaylılar ketçabı ters döküp marulu dua ederek dizdi mi, lezzet boyut kapısı açılır.
          </p>
          <p>
            Turşular 7 kere kuzeye döndürülüp peynirle fısıldaşmadan burger tamamlanmaz.
          </p>
          <p>
           Karamelize soğan, gizli sosla yıldız haritası çakışınca burger kutsanır.
          </p>
          <h3>DÜKKANIMIZIN TARİHÇESİ</h3>
          <p>1983’te, kasabanın en aç gecesinde, ilk burger ekmeği yıldırım çarpmış tavada kızartıldı.
            Kurucu Gaffar Usta, tarifini rüyasında dans eden bir inekten aldığını iddia etti.
            İlk müşteri burgeri yedikten sonra gözyaşı döktü, sonra da her gün geldi.
            Bugün hâlâ aynı tavayla pişiyor, ama inek hâlâ sır vermiyor.
          </p>
          <a href="#" class="btn">Daha Fazla</a>
        </div>
      </div>
    </section>
    <!--! about section end  -->

    <!--! footer section start  -->
    <?php include 'partials/footer.php'; ?>
    <!--! footer section end  -->

    <script src="assets/js/script.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>
