<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (!empty($name) && !empty($email) && !empty($phone)) {
        $stmt = $db->prepare("INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $phone]);
        header("Location: index.php");
        exit;
    }
}

$page_title = "İletişim";
$active_page = "contact";

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

    <!--! contact section start  -->
    <section class="contact" id="contact">
      <h1 class="heading">contact <span>us</span></h1>
      <div class="row">
        <iframe
        class="map"
       src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3033.2585281311947!2d33.5124878!3d38.966256!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14d440d97a7f8343%3A0xbb45ab9ff76e8ab!2zU8SxbiBPdG8gU2Vydmlz!5e0!3m2!1str!2str!4v1716384320000!5m2!1str!2str"
       loading="lazy"
       referrerpolicy="no-referrer-when-downgrade">
     </iframe>

        <form action="contact.php" method="post">
          <h3>Bizimle İletişime Geçin</h3>
          <div class="inputBox">
            <i class="fas fa-user"></i>
            <input type="text" name="name" placeholder="isim" required />
          </div>
          <div class="inputBox">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="email" required />
          </div>
          <div class="inputBox">
            <i class="fas fa-phone"></i>
            <input type="text" name="phone" placeholder="numara" required />
          </div>
          <input type="submit" class="btn" value="Şimdi İletişime Geçin" />
        </form>
      </div>
    </section>
    <!--! contact section end  -->

    <!--! footer section start  -->
    <?php include 'partials/footer.php'; ?>
    <!--! footer section end  -->

    <script src="assets/js/script.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>
