<?php
require_once 'config/db.php';

$page_title = "Yeni Blog Yazısı";
$active_page = "blogs";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $author = $_POST['author'] ?? 'Admin';
    $publish_date = $_POST['publish_date'] ?? date('Y-m-d');
    
    // Resim yükleme işlemi
    $image = 'blog-default.jpg'; // Varsayılan resim
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'assets/images/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        
        // Dosya uzantısı kontrolü
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $image = basename($_FILES['image']['name']);
            }
        }
    }
    
    // Veritabanına ekleme
    $stmt = $db->prepare("INSERT INTO blogs (title, content, image, author, publish_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $content, $image, $author, $publish_date]);
    
    header("Location: blogs.php?success=1");
    exit;
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
    <style>
        .blog-form {
            max-width: 800px;
            margin: 0 auto;
            padding: 3rem;
            background: #fff;
            border-radius: 3rem;
        }
        .form-group {
            margin-bottom: 2rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1.6rem;
            color: var(--black-color);
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1.6rem;
        }
        .form-group textarea {
            min-height: 300px;
        }
    </style>
</head>
<body>
    <!--! header section start  -->
    <?php include 'partials/header.php'; ?>
    <!--! header section end  -->

    <section class="blog-form-section">
        <h1 class="heading">Yeni <span>Blog Yazısı</span></h1>
        
        <form class="blog-form" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Başlık:</label>
                <input type="text" id="title" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="content">İçerik:</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="author">Yazar:</label>
                <input type="text" id="author" name="author" value="<?php echo $_SESSION['username'] ?? 'Admin'; ?>">
            </div>
            
            <div class="form-group">
                <label for="publish_date">Yayın Tarihi:</label>
                <input type="date" id="publish_date" name="publish_date" value="<?php echo date('Y-m-d'); ?>">
            </div>
            
            <div class="form-group">
                <label for="image">Kapak Resmi:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            
            <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn">Yazıyı Kaydet</button>
                <a href="blogs.php" class="btn" style="background: #ccc; margin-left: 1rem;">İptal</a>
            </div>
        </form>
    </section>

    <!--! footer section start  -->
    <?php include 'partials/footer.php'; ?>
    <!--! footer section end  -->

    <script src="assets/js/script.js"></script>
</body>
</html>