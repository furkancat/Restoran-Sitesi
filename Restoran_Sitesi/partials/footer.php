<!--! footer section start  -->
    <section class="footer">
        <div class="search">
            <form action="search.php" method="GET">
                <input type="text" class="search-input" placeholder="Ara" name="q" />
                <button type="submit" class="btn btn-primary">Ara</button>
            </form>
        </div>
        <div class="share">
            <a href="#" class="fab fa-facebook"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
            <a href="#" class="fab fa-pinterest"></a>
        </div>

        <div class="links">
            <a <?php echo $active_page == 'home' ? 'class="active"' : ''; ?> href="index.php">Anasayfa</a>
            <a <?php echo $active_page == 'about' ? 'class="active"' : ''; ?> href="about.php">Hakkımızda</a>
            <a <?php echo $active_page == 'menu' ? 'class="active"' : ''; ?> href="menu.php">Menü</a>
            <a <?php echo $active_page == 'products' ? 'class="active"' : ''; ?> href="products.php">Ürünler</a>
            <a <?php echo $active_page == 'review' ? 'class="active"' : ''; ?> href="review.php">Yorumlar</a>
            <a <?php echo $active_page == 'contact' ? 'class="active"' : ''; ?> href="contact.php">İletişim</a>
            <a <?php echo $active_page == 'blogs' ? 'class="active"' : ''; ?> href="blogs.php">Blog</a>
        </div>
    </section>
    <!--! footer section end  -->