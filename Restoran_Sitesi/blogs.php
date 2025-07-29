<?php
require_once 'config/db.php';

$page_title = "Blog Yazıları";
$active_page = "blogs";

// Son blog yazılarını çek
$blogs = $db->query("SELECT * FROM blogs ORDER BY publish_date DESC")->fetchAll(PDO::FETCH_ASSOC);
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
        .add-blog-btn {
            text-align: center;
            margin-bottom: 3rem;
        }
        .add-blog-btn .btn {
            background-color: var(--black-color);
            color: white;
            padding: 1.5rem 3rem;
            font-size: 1.8rem;
        }
        .add-blog-btn .btn:hover {
            background-color: var(--black-color);
        }
    </style>
</head>
<body>
    <!--! header section start  -->
    <?php include 'partials/header.php'; ?>
    <!--! header section end  -->

    <!--! blogs section start  -->
    <section class="blogs" id="blogs">
        <h1 class="heading">Blog <span>Yazıları</span></h1>
        
        <!-- Yeni Blog Ekle Butonu -->
        <div class="add-blog-btn">
            <a href="add_blog.php" class="btn">
                <i class="fas fa-plus"></i> Yeni Blog Yazısı Ekle
            </a>
        </div>
        
        <div class="box-container">
            <?php if (empty($blogs)): ?>
                <p class="empty">Henüz blog yazısı eklenmemiş.</p>
            <?php else: ?>
                <?php foreach ($blogs as $blog): ?>
                <div class="box">
                    <div class="image">
                        <img src="assets/images/<?php echo htmlspecialchars($blog['image']); ?>" alt="blog" />
                    </div>
                    <div class="content">
                        <a href="blog_detail.php?id=<?php echo $blog['id']; ?>" class="title"><?php echo htmlspecialchars($blog['title']); ?></a>
                        <span>Yazar: <?php echo htmlspecialchars($blog['author']); ?> | <?php echo date('d M, Y', strtotime($blog['publish_date'])); ?></span>
                        <p><?php echo substr(htmlspecialchars($blog['content']), 0, 100); ?>...</p>
                        <a href="blog_detail.php?id=<?php echo $blog['id']; ?>" class="btn">Devamını Oku</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
    <!--! blogs section end  -->

    <!--! footer section start  -->
    <?php include 'partials/footer.php'; ?>
    <!--! footer section end  -->

    <script src="assets/js/script.js"></script>
</body>
</html>