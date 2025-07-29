CREATE DATABASE IF NOT EXISTS restaurant_db;
USE restaurant_db;

-- Kategoriler tablosu
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ürünler tablosu
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    calories VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Yorumlar tablosu
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    user_image VARCHAR(255),
    comment TEXT NOT NULL,
    rating INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blog gönderileri tablosu
CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    author VARCHAR(100),
    publish_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Kullanıcılar tablosu (admin paneli için)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Siparişler tablosu
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    items JSON NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Ödeme yöntemleri tablosu (opsiyonel)
CREATE TABLE IF NOT EXISTS payment_methods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE
);
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
select * from contacts;

select * from orders;

-- Örnek ödeme yöntemleri ekleme
INSERT INTO payment_methods (name, description) VALUES
('Kredi Kartı', 'Online kredi kartı ödemesi'),
('Nakit', 'Kapıda nakit ödeme'),
('Banka Havalesi', 'Önceden banka havalesi');

-- Örnek veriler
INSERT INTO categories (name) VALUES 
('Burger'), ('Pizza'), ('İçecek'), ('Tatlı');

INSERT INTO products (category_id, name, description, price, image, calories) VALUES
(1, 'Klasik Burger', 'Etli nefis burger', 45.99, 'menu-1.png', '550 cal'),
(1, 'Cheese Burger', 'Peynirli burger', 49.99, 'menu-2.png', '600 cal'),
(2, 'Margarita Pizza', 'Klasik margarita', 79.99, 'menu-3.png', '800 cal'),
(2, 'Sucuklu Pizza', 'Bol sucuklu pizza', 89.99, 'menu-4.png', '850 cal');

INSERT INTO reviews (user_name, user_image, comment, rating) VALUES
('Ahmet Yılmaz', 'avatar-1.png', 'Harika lezzetler, kesinlikle tavsiye ederim!', 5),
('Ayşe Demir', 'avatar-2.png', 'Servis biraz yavaştı ama yemekler mükemmeldi', 4),
('Mehmet Kaya', 'avatar-3.png', 'Fiyat-performans ürünleri çok iyi', 5);
select * from reviews;
update reviews set user_name = 'Belkıs Büyükpatpat' where id = 3;

INSERT INTO blogs (title, content, image, author, publish_date) VALUES
('Burger Yapmanın Sırları', 'İşte evde mükemmel burger yapmanın püf noktaları...', 'blog-1.jpg', 'Şef Ali', '2023-01-15'),
('Sağlıklı Pizza Tarifi', 'Diyet yaparken pizza yemek isteyenler için harika bir tarif...', 'blog-2.jpg', 'Diyetisyen Zeynep', '2023-02-20');

select * from users;
INSERT INTO users (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com');
INSERT INTO users (username, password, email) VALUES ('admin1', '123', 'admin1@example.com');