<?php
$host = 'localhost';
$dbname = 'restaurant_db';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

// Oturumu başlat
session_start();

// Sepet kontrolü
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Sepet sayısını hesaplayan fonksiyon
function getCartCount() {
    return array_sum(array_column($_SESSION['cart'], 'quantity'));
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>