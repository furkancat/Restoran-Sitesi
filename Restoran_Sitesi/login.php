<?php 
$page_title = "Giriş Yap";
include('header.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if(!empty($username) && !empty($password)) {
        $query = $db->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute([$username]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Kullanıcı adı veya şifre hatalı!";
        }
    } else {
        $error = "Lütfen tüm alanları doldurun!";
    }
}
?>

<section class="login">
    <div class="container">
        <h2>Giriş Yap</h2>
        <?php if(isset($error)): ?>
            <div class="alert"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Giriş Yap</button>
        </form>
        <p>Hesabınız yok mu? <a href="register.php">Kayıt Olun</a></p>
    </div>
</section>

<?php include('footer.php'); ?>