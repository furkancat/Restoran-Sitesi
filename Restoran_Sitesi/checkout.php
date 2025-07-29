<?php
require_once 'config/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = "Ödeme";
$active_page = "checkout";

// Sepet boşsa yönlendir
if (empty($_SESSION['cart'])) {
    header('Location: products.php');
    exit;
}

// Ödeme yöntemlerini veritabanından çek
$payment_methods = [];
try {
    $stmt = $db->query("SELECT * FROM payment_methods WHERE is_active = TRUE");
    $payment_methods = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Ödeme yöntemleri çekilirken hata: " . $e->getMessage());
}

// Toplam tutarı hesapla
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Form gönderildiyse
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $address = htmlspecialchars(trim($_POST['address']));
    $payment_method = htmlspecialchars(trim($_POST['payment_method']));
    
    // Validasyon
    $errors = [];
    if (empty($name)) $errors[] = "Ad soyad gereklidir";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Geçerli bir email adresi girin";
    if (empty($phone)) $errors[] = "Telefon numarası gereklidir";
    if (empty($address)) $errors[] = "Adres gereklidir";
    if (empty($payment_method)) $errors[] = "Ödeme yöntemi seçmelisiniz";
    
    if (empty($errors)) {
        // Siparişi veritabanına kaydet
        $items_json = json_encode($_SESSION['cart']);
        
        try {
            $stmt = $db->prepare("INSERT INTO orders 
                (customer_name, customer_email, customer_phone, address, items, total_price, payment_method) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            $db->beginTransaction();
            $stmt->execute([$name, $email, $phone, $address, $items_json, $total, $payment_method]);
            
            // Sipariş numarasını al
            $order_id = $db->lastInsertId();
            
            // Sepeti temizle
            unset($_SESSION['cart']);
            
            // Sipariş oturumuna kaydet (order_complete.php'de kullanmak için)
            $_SESSION['last_order'] = [
                'id' => $order_id,
                'total' => $total,
                'customer_name' => $name
            ];
            
            $db->commit();
            
            // Teşekkür sayfasına yönlendir
            header("Location: index.php");
            exit;
            
        } catch(PDOException $e) {
            $db->rollBack();
            $errors[] = "Sipariş kaydedilirken bir hata oluştu. Lütfen tekrar deneyin.";
            error_log("Sipariş hatası: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $page_title; ?> | Restaurant Web Site</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
        .checkout .row {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-top: 2rem;
        }
        .order-summary, .checkout-form {
            flex: 1;
            min-width: 300px;
            background: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }
        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 1.8rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 2px solid var(--main-color);
        }
        .error-message {
            color: #e84242;
            background: #ffecec;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
        }
        .inputBox {
            margin-bottom: 1.5rem;
        }
        .inputBox label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .inputBox input,
        .inputBox textarea,
        .inputBox select {
            width: 100%;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1.6rem;
        }
    </style>
</head>
<body>
    <!--! header section start  -->
    <?php include 'partials/header.php'; ?>
    <!--! header section end  -->

    <!--! checkout section start  -->
    <section class="checkout" id="checkout">
        <h1 class="heading">Ödeme <span>Sayfası</span></h1>
        
        <div class="row">
            <div class="order-summary">
                <h3>Sipariş Özeti</h3>
                <div class="summary-items">
                    <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <div class="summary-item">
                        <div class="item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                        <div class="item-quantity"><?php echo $item['quantity']; ?> adet</div>
                        <div class="item-price">₺<?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="summary-total">
                    <span>Toplam:</span>
                    <span>₺<?php echo number_format($total, 2); ?></span>
                </div>
            </div>
            
            <div class="checkout-form">
                <h3>Fatura Bilgileri</h3>
                
                <?php if (!empty($errors)): ?>
                    <div class="error-message">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="inputBox">
                        <label>Ad Soyad *</label>
                        <input type="text" name="name" value="<?php echo $_POST['name'] ?? ''; ?>" required>
                    </div>
                    <div class="inputBox">
                        <label>Email *</label>
                        <input type="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                    </div>
                    <div class="inputBox">
                        <label>Telefon *</label>
                        <input type="text" name="phone" value="<?php echo $_POST['phone'] ?? ''; ?>" required>
                    </div>
                    <div class="inputBox">
                        <label>Adres *</label>
                        <textarea name="address" rows="3" required><?php echo $_POST['address'] ?? ''; ?></textarea>
                    </div>
                    <div class="inputBox">
                        <label>Ödeme Yöntemi *</label>
                        <select name="payment_method" required>
                            <option value="">Seçiniz</option>
                            <?php foreach ($payment_methods as $method): ?>
                                <option value="<?php echo $method['name']; ?>"
                                    <?php echo ($_POST['payment_method'] ?? '') == $method['name'] ? 'selected' : ''; ?>>
                                    <?php echo $method['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn">Siparişi Tamamla</button>
                </form>
            </div>
        </div>
    </section>
    <!--! checkout section end  -->

    <!--! footer section start  -->
    <?php include 'partials/footer.php'; ?>
    <!--! footer section end  -->

    <script src="assets/js/script.js"></script>
</body>
</html>