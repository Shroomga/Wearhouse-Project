-- Wearhouse Database Setup Script
-- Run this script to create the necessary database and tables

CREATE DATABASE IF NOT EXISTS wearhousedb;
USE wearhousedb;

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    type ENUM('customer', 'seller', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    details TEXT,
    image VARCHAR(255),
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Cart table
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert sample categories
INSERT INTO categories (name, description) VALUES
('Shirts', 'Various types of shirts'),
('Trousers', 'Pants and trousers'),
('Hats and Accessories', 'Hats, belts, and other accessories'),
('Jackets', 'Coats and jackets'),
('Blouses', 'Women\'s blouses and tops'),
('Shoes', 'Footwear for all occasions');

-- Insert sample products
INSERT INTO products (name, price, details, image, category_id) VALUES
('Classic White Shirt', 29.99, 'A comfortable white cotton shirt perfect for any occasion', 'white-shirt.jpg', 1),
('Blue Denim Jeans', 49.99, 'Classic blue denim jeans with a comfortable fit', 'blue-jeans.jpg', 2),
('Baseball Cap', 19.99, 'Adjustable baseball cap in various colors', 'baseball-cap.jpg', 3),
('Winter Jacket', 89.99, 'Warm winter jacket with insulation', 'winter-jacket.jpg', 4),
('Silk Blouse', 39.99, 'Elegant silk blouse for professional wear', 'silk-blouse.jpg', 5),
('Running Shoes', 79.99, 'Comfortable running shoes with good support', 'running-shoes.jpg', 6);

SELECT 'Database setup completed successfully!' as message; 