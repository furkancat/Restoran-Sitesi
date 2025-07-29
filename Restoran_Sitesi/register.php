<?php 
$page_title = "Kayıt Ol";
include('header.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    $errors = [];
    
    if(empty($username)) {
        $errors[] = "Kullanıcı adı gereklidir!";
    }
    
    if(empty($email)) {
        $errors[] = "E-posta gereklidir!";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Geçersiz e-posta formatı!";
    }
    
    if(empty($password)) {
        $errors[] = "Şifre gereklidir!";
    } elseif(strlen($password) < 6) {
        $errors[] = "Şifre en az 6 karakter olmalıdır!";
    }
    
    if($password !== $confirm_password) {
        $errors[] = "Şifreler eşleşmiyor!";
    }
    
    if(empty($errors)) {
        // Kullanıcı adı ve e-posta kontrolü
        $query = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $query->execute([$username, $email]);
        
        if($query->rowCount() > 0) {
            $errors[] = "Bu kullanıcı adı veya e-posta zaten kullanımda!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $insert->execute([$username, $email, $hashed_password]);
            
            if($insert->rowCount() > 0) {
                $success = "Kayıt başarılı! Giriş yapabilirsiniz.";
                header("refresh:2;url=login.php");
            }
        }
    }
}
?>

<section class="register">
    <div class="container">
        <h2>Kayıt Ol</h2>
        <?php if(!empty($errors)): ?>
            <div class="alert">
                <?php foreach($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php elseif(isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">E-posta</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Şifre Tekrar</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn">Kayıt Ol</button>
        </form>
        <p>Zaten hesabınız var mı? <a href="login.php">Giriş Yapın</a></p>
    </div>
</section>

<?php include('footer.php'); ?>