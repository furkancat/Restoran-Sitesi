<?php
require_once 'config/db.php';

$page_title = "Yorum Ekle";
$active_page = "review";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $comment = $_POST['comment'] ?? '';
    $rating = (int)($_POST['rating'] ?? 0);
    
    // Basic validation
    if (!empty($name) && !empty($comment) && $rating > 0 && $rating <= 5) {
        // Handle image upload
        $imagePath = 'avatar-default.png'; // Default image
        if (isset($_FILES['user_image'])) {
            $uploadDir = 'assets/images/';
            $uploadFile = $uploadDir . basename($_FILES['user_image']['name']);
            
            // Check if image file is valid
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['user_image']['tmp_name'], $uploadFile)) {
                    $imagePath = basename($_FILES['user_image']['name']);
                }
            }
        }
        
        // Insert review into database
        $stmt = $db->prepare("INSERT INTO reviews (user_name, user_image, comment, rating) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $imagePath, $comment, $rating]);
        
        header('Location: review.php?success=1');
        exit;
    }
}
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

    <section class="review-form">
        <h1 class="heading">Yorum <span>Ekle</span></h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Yorumunuz başarıyla eklendi!</div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="inputBox">
                <label for="name">Adınız:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="inputBox">
                <label for="comment">Yorumunuz:</label>
                <textarea id="comment" name="comment" rows="5" required></textarea>
            </div>
            
            <div class="inputBox">
                <label>Puanınız:</label>
                <div class="rating-stars">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" required>
                        <label for="star<?php echo $i; ?>"><i class="fas fa-star"></i></label>
                    <?php endfor; ?>
                </div>
            </div>
            
            <div class="inputBox">
                <label for="user_image">Profil Resmi (opsiyonel):</label>
                <input type="file" id="user_image" name="user_image" accept="image/*">
            </div>
            
            <button type="submit" class="btn">Yorumu Gönder</button>
        </form>
    </section>

    <!--! footer section start  -->
    <?php include 'partials/footer.php'; ?>
    <!--! footer section end  -->

    <script src="assets/js/script.js"></script>
</body>
</html>