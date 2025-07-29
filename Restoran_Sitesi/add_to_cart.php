<?php
include('config.php');

header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Giriş yapmalısınız']);
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['user_id'];
    
    // Ürün var mı kontrol et
    $query = $db->prepare("SELECT * FROM products WHERE id = ?");
    $query->execute([$product_id]);
    
    if($query->rowCount() > 0) {
        // Sepette zaten var mı kontrol et
        $check = $db->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $check->execute([$user_id, $product_id]);
        
        if($check->rowCount() > 0) {
            // Miktarı artır
            $update = $db->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
            $update->execute([$user_id, $product_id]);
        } else {
            // Yeni ekle
            $insert = $db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
            $insert->execute([$user_id, $product_id]);
        }
        
        echo json_encode(['success' => true, 'message' => 'Ürün sepete eklendi']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ürün bulunamadı']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek']);
}
?>