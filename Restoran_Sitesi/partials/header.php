<header class="header">
    <a href="index.php" class="logo">
        <img src="assets/images/logo.png" alt="logo" />
    </a>
    <nav class="navbar">
        <a <?php echo $active_page == 'home' ? 'class="active"' : ''; ?> href="index.php">Anasayfa</a>
        <a <?php echo $active_page == 'about' ? 'class="active"' : ''; ?> href="about.php">Hakkımızda</a>
        <a <?php echo $active_page == 'menu' ? 'class="active"' : ''; ?> href="menu.php">Menü</a>
        <a <?php echo $active_page == 'products' ? 'class="active"' : ''; ?> href="products.php">Ürünler</a>
        <a <?php echo $active_page == 'review' ? 'class="active"' : ''; ?> href="review.php">Yorumlar</a>
        <a <?php echo $active_page == 'contact' ? 'class="active"' : ''; ?> href="contact.php">İletişim</a>
        <a <?php echo $active_page == 'blogs' ? 'class="active"' : ''; ?> href="blogs.php">Blog</a>
    </nav>

    <div class="buttons">
        <button id="search-btn">
            <i class="fas fa-search"></i>
        </button>
        <button id="cart-btn">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count"><?php echo getCartCount(); ?></span>
        </button>
        <button id="menu-btn">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="search-form">
        <form action="search.php" method="GET">
    <input type="text" class="search-input" id="search-box" name="q" placeholder="Arama yapın..." />
    <button type="submit"><i class="fas fa-search"></i></button>
</form>


    </div>

    <div class="cart-items-container">
        <?php include 'partials/cart_items.php'; ?>
    </div>
</header>