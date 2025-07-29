<?php
require_once (__DIR__ . '/../config/db.php');

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Geçersiz istek metodu');
    }

    if (!isset($_POST['product_id'])) {
        throw new Exception('Ürün ID eksik');
    }

    $productId = (int)$_POST['product_id'];
    
    if ($productId <= 0) {
        throw new Exception('Geçersiz ürün ID');
    }

    // Ürünü veritabanından kontrol et
    $stmt = $db->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
    if (!$stmt->execute([$productId])) {
        throw new Exception('Veritabanı sorgu hatası');
    }
    
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        throw new Exception('Ürün bulunamadı');
    }
    
    // Oturumu başlat
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Sepet kontrolü
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Sepete ekle
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$productId] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => 1
        ];
    }
    
    // Sepet sayısını hesapla
    $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
    
    echo json_encode([
        'success' => true, 
        'cart_count' => $cartCount,
        'cart' => $_SESSION['cart']
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage(),
        'debug' => [
            'post_data' => $_POST,
            'session' => $_SESSION ?? null
        ]
    ]);
}