<?php
require_once 'config/db.php';

// Blog ID'sini al
$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Belirtilen blog yazısını veritabanından çek
$blog = $db->prepare("SELECT * FROM blogs WHERE id = ?");
$blog->execute([$blog_id]);
$blog = $blog->fetch(PDO::FETCH_ASSOC);

// Eğer blog bulunamazsa 404 sayfasına yönlendir
if (!$blog) {
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit;
}

$page_title = htmlspecialchars($blog['title']);
$active_page = "blogs";

// Son 3 blog yazısını sidebar için çek
$recent_blogs = $db->query("SELECT id, title, image FROM blogs WHERE id != $blog_id ORDER BY publish_date DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo htmlspecialchars(substr($blog['content'], 0, 160)); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title><?php echo $page_title; ?> | Restaurant Web Site</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
        /* Blog Detay Özel Stilleri */
        .blog-detail {
            display: flex;
            gap: 3rem;
            margin-top: 3rem;
        }
        
        .blog-content {
            flex: 2;
            background: #fff;
            padding: 3rem;
            border-radius: 3rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .blog-sidebar {
            flex: 1;
        }
        
        .blog-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .blog-header img {
            max-width: 100%;
            border-radius: 2rem;
            margin-bottom: 2rem;
        }
        
        .blog-meta {
            color: #777;
            margin-bottom: 2rem;
            font-size: 1.4rem;
        }
        
        .blog-body {
            line-height: 1.8;
            font-size: 1.6rem;
        }
        
        .recent-blogs .box {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            background: #fff;
            padding: 1.5rem;
            border-radius: 1.5rem;
            align-items: center;
        }
        
        .recent-blogs img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 1rem;
        }
        
        @media (max-width: 768px) {
            .blog-detail {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!--! header section start  -->
    <?php include 'partials/header.php'; ?>
    <!--! header section end  -->

    <!--! blog detail section start  -->
    <section class="blog-detail-section">
        <h1 class="heading">Blog <span>Detayı</span></h1>
        
        <div class="blog-detail">
            <article class="blog-content">
                <div class="blog-header">
                    <img src="assets/images/<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" />
                    <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                    <div class="blog-meta">
                        <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($blog['author']); ?></span> | 
                        <span><i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($blog['publish_date'])); ?></span>
                    </div>
                </div>
                
                <div class="blog-body">
                    <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
                </div>
            </article>
            
            <aside class="blog-sidebar">
                <h3>Son Blog Yazıları</h3>
                <div class="recent-blogs">
                    <?php foreach ($recent_blogs as $recent): ?>
                    <div class="box">
                        <img src="assets/images/<?php echo htmlspecialchars($recent['image']); ?>" alt="<?php echo htmlspecialchars($recent['title']); ?>" />
                        <div>
                            <a href="blog_detail.php?id=<?php echo $recent['id']; ?>"><?php echo htmlspecialchars($recent['title']); ?></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="back-to-blogs">
                    <a href="blogs.php" class="btn"><i class="fas fa-arrow-left"></i> Tüm Bloglar</a>
                </div>
            </aside>
        </div>
    </section>
    <!--! blog detail section end  -->

    <!--! footer section start  -->
    <?php include 'partials/footer.php'; ?>
    <!--! footer section end  -->

    <script src="assets/js/script.js"></script>
</body>
</html>