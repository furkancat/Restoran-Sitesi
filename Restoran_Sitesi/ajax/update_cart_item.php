<?php
require_once (__DIR__ . '/../config/db.php');

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Geçersiz istek metodu');
    }

    if (!isset($_POST['product_id']) || !isset($_POST['change'])) {
        throw new Exception('Eksik parametre');
    }

    $productId = (int)$_POST['product_id'];
    $change = (int)$_POST['change'];
    
    if ($productId <= 0) {
        throw new Exception('Geçersiz ürün ID');
    }

    // Oturumu başlat
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Sepette ürün varsa güncelle
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $change;
        
        // Eğer miktar 0 veya daha az olduysa ürünü sepetten çıkar
        if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
            unset($_SESSION['cart'][$productId]);
        }
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
        'message' => $e->getMessage()
    ]);
}