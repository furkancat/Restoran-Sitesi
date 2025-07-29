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
    
    $delete = $db->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $delete->execute([$user_id, $product_id]);
    
    echo json_encode(['success' => true, 'message' => 'Ürün sepetten kaldırıldı']);
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek']);
}
?>