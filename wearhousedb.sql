-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2025 at 08:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wearhousedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(1, 5, 7, 1, '2024-01-23 13:30:00'),
(2, 5, 14, 1, '2024-01-23 13:32:00'),
(3, 6, 4, 2, '2024-01-23 14:15:00'),
(4, 7, 11, 1, '2024-01-23 15:20:00'),
(5, 7, 16, 1, '2024-01-23 15:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `parent_id`, `created_at`) VALUES
(1, 'Men\'s Clothing', 'Clothing items for men', NULL, '2025-06-14 11:32:56'),
(2, 'Women\'s Clothing', 'Clothing items for women', NULL, '2025-06-14 11:32:56'),
(3, 'Shoes', 'Footwear for all genders', NULL, '2025-06-14 11:32:56'),
(4, 'Accessories', 'Fashion accessories', NULL, '2025-06-14 11:32:56'),
(5, 'Sportswear', 'Athletic and sports clothing', NULL, '2025-06-14 11:32:56'),
(6, 'T-Shirts', 'Men\'s T-shirts', 1, '2025-06-14 11:32:56'),
(7, 'Jeans', 'Men\'s jeans and denim pants', 1, '2025-06-14 11:32:56'),
(8, 'Jackets', 'Men\'s jackets and coats', 1, '2025-06-14 11:32:56'),
(9, 'Dresses', 'Women\'s dresses', 2, '2025-06-14 11:32:56'),
(10, 'Tops', 'Women\'s tops and blouses', 2, '2025-06-14 11:32:56'),
(11, 'Pants', 'Women\'s pants and trousers', 2, '2025-06-14 11:32:56'),
(12, 'Sneakers', 'Casual sneakers', 3, '2025-06-14 11:32:56'),
(13, 'Boots', 'Boots for all occasions', 3, '2025-06-14 11:32:56'),
(14, 'Bags', 'Handbags and backpacks', 4, '2025-06-14 11:32:56'),
(15, 'Jewelry', 'Fashion jewelry', 4, '2025-06-14 11:32:56'),
(16, 'Keychains', 'Keychain apparel', 4, '2025-06-14 11:32:56'),
(17, 'Watches', 'Wrist watches', 4, '2025-06-14 11:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `receiver_id`, `product_id`, `subject`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 1, 'Question about sizing', 'Hi, do these jeans run true to size? I usually wear 32x34.', 1, '2024-01-10 07:15:00'),
(2, 5, 1, 'Re: Question about sizing', 'Yes, they run true to size. The 32x34 should fit you perfectly!', 1, '2024-01-10 08:30:00'),
(3, 2, 5, 'Interested in the dress', 'Is this dress available in size Small?', 0, '2024-01-23 12:20:00'),
(4, 3, 8, 'Delivery question', 'When can you ship this item?', 0, '2024-01-23 14:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `order_status` enum('pending','confirmed','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `shipped_date` timestamp NULL DEFAULT NULL,
  `delivered_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `buyer_id`, `total_price`, `shipping_address`, `payment_method`, `order_status`, `payment_status`, `order_date`, `shipped_date`, `delivered_date`) VALUES
(1, 5, 2789.64, '21 Adderley St, Cape Town, 8001', 'Credit Card', 'delivered', 'paid', '2024-01-15 08:30:00', NULL, NULL),
(2, 6, 1619.82, '55 Loop St, Cape Town, 8001', 'PayPal', 'shipped', 'paid', '2024-01-18 12:20:00', NULL, NULL),
(3, 7, 4499.64, '101 Florida Rd, Durban, 4001', 'Credit Card', 'processing', 'paid', '2024-01-20 07:45:00', NULL, NULL),
(4, 5, 1439.82, '21 Adderley St, Cape Town, 8001', 'Credit Card', 'confirmed', 'paid', '2024-01-22 14:15:00', NULL, NULL),
(5, 6, 5759.46, '55 Loop St, Cape Town, 8001', 'Credit Card', 'pending', 'pending', '2024-01-23 09:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `seller_id`, `quantity`, `price`, `total`) VALUES
(1, 1, 1, 1, 1, 1619.82, 1619.82),
(2, 1, 9, 2, 1, 1079.82, 1079.82),
(3, 1, 2, 2, 1, 449.82, 449.82),
(4, 2, 1, 1, 1, 1619.82, 1619.82),
(5, 3, 3, 2, 1, 5399.82, 5399.82),
(6, 3, 10, 3, 1, 2699.82, 2699.82),
(7, 4, 5, 2, 1, 1439.82, 1439.82),
(8, 5, 13, 2, 1, 3419.82, 3419.82),
(9, 5, 15, 2, 1, 3599.82, 3599.82),
(10, 5, 8, 4, 1, 2339.82, 2339.82);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `color` varchar(50) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `size` varchar(40) DEFAULT NULL,
  `status` enum('active','inactive','sold') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `color`, `brand`, `image_url`, `size`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 6, 'Classic Blue Denim Jeans', 'High-quality men\'s denim jeans with classic fit', 89.99, 15, 'Blue', 'Levi\'s', 'images/products/mens-jeans-1.jpg', '32W x 34L', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(2, 2, 6, 'Vintage Cotton T-Shirt', 'Comfortable vintage-style cotton t-shirt', 24.99, 25, 'White', 'Hanes', 'images/products/mens-tshirt-1.jpg', 'L', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(3, 3, 8, 'Leather Bomber Jacket', 'Genuine leather bomber jacket for men', 299.99, 5, 'Black', 'Calvin Klein', 'images/products/mens-jacket-1.jpg', 'M', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(4, 2, 6, 'Slim Fit Chinos', 'Modern slim fit chino pants', 65.99, 20, 'Khaki', 'Dockers', 'images/products/mens-chinos-1.jpg', '30W x 32L', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(5, 3, 9, 'Floral Summer Dress', 'Beautiful floral print summer dress', 79.99, 12, 'Pink', 'Zara', 'images/products/womens-dress-1.jpg', 'M', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(6, 4, 10, 'Silk Blouse', 'Elegant silk blouse for professional wear', 89.99, 8, 'Cream', 'Express', 'images/products/womens-blouse-1.jpg', 'S', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(7, 3, 11, 'High-Waisted Jeans', 'Trendy high-waisted skinny jeans', 69.99, 18, 'Dark Blue', 'American Eagle', 'images/products/womens-jeans-1.jpg', '28W x 30L', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(8, 4, 9, 'Little Black Dress', 'Classic little black dress for evening wear', 129.99, 6, 'Black', 'Ann Taylor', 'images/products/womens-dress-2.jpg', 'L', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(9, 2, 12, 'White Canvas Sneakers', 'Classic white canvas sneakers', 59.99, 30, 'White', 'Converse', 'images/products/sneakers-1.jpg', '9', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(10, 3, 13, 'Oxford Dress Shoes', 'Men\'s leather oxford dress shoes', 149.99, 10, 'Brown', 'Cole Haan', 'images/products/dress-shoes-1.jpg', '10', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(11, 4, 14, 'Ankle Boots', 'Women\'s leather ankle boots', 119.99, 15, 'Black', 'Steve Madden', 'images/products/ankle-boots-1.jpg', '8', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(12, 2, 12, 'Running Sneakers', 'Performance running sneakers', 129.99, 22, 'Blue', 'Nike', 'images/products/running-shoes-1.jpg', '9.5', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(13, 3, 15, 'Leather Handbag', 'Genuine leather handbag with multiple compartments', 189.99, 7, 'Brown', 'Coach', 'images/products/handbag-1.jpg', 'One Size', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(14, 4, 16, 'Silver Necklace', 'Sterling silver chain necklace', 45.99, 20, 'Silver', 'Pandora', 'images/products/necklace-1.jpg', 'One Size', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(15, 2, 17, 'Digital Watch', 'Modern digital sports watch', 199.99, 12, 'Black', 'Casio', 'images/products/watch-1.jpg', 'One Size', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53'),
(16, 3, 15, 'Canvas Backpack', 'Durable canvas backpack for daily use', 49.99, 25, 'Navy', 'Jansport', 'images/products/backpack-1.jpg', 'One Size', 'active', '2025-06-14 11:37:53', '2025-06-14 11:37:53');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('sale','refund') DEFAULT 'sale',
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `seller_id`, `buyer_id`, `amount`, `commission`, `net_amount`, `transaction_type`, `status`, `transaction_date`) VALUES
(1, 1, 1, 5, 2789.64, 279.00, 2510.64, 'sale', 'completed', '2024-01-15 08:30:00'),
(2, 2, 1, 6, 1619.82, 162.00, 1457.82, 'sale', 'completed', '2024-01-18 12:20:00'),
(3, 3, 2, 7, 4499.64, 450.00, 4049.64, 'sale', 'completed', '2024-01-20 07:45:00'),
(4, 4, 2, 5, 1439.82, 144.00, 1295.82, 'sale', 'completed', '2024-01-22 14:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `email` varchar(125) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `role` enum('buyer','seller','admin') DEFAULT 'buyer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `phone`, `address`, `city`, `province`, `zip_code`, `role`, `created_at`, `updated_at`) VALUES
(1, 'fashionista_jane', 'jane@example.com', '$2a$12$Fh6Q9rahTAQwCx/W3d3EmO3zZcwrK4mk0tpp.NL7VxUtaomLuX1kK', 'Jane', 'Smith', '086 129 2966', '123 Fashion St', 'Johannesburg', 'GP', '2000', 'seller', '2025-06-14 11:32:56', '2025-06-14 11:32:56'),
(2, 'kevin_the_man', 'kevin@example.com', '$2a$12$EeB.YR2CPMQHiF/yybRKlOXb2me1.5lIcpmy4vumZa6Q6TMf0Sqdy', 'Kevin', 'Johnson', '011 782 0911', '456 Style Ave', 'Johannesburg', 'GP', '2000', 'seller', '2025-06-14 11:32:56', '2025-06-14 11:32:56'),
(3, 'sweet_sue', 'sue@example.com', '$2a$12$l3OhNvJGwfABT.GNX4uj8ejbS8YwBCEhLAZg2/bXKn0WBxTCdJs7C', 'Sue', 'Wilson', '028 514 1812', '789 Trend Blvd', 'Durban', 'KZN', '4001', 'seller', '2025-06-14 11:32:56', '2025-06-14 11:32:56'),
(4, 'admin', 'admin@wearhouse.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System', 'Administrator', NULL, NULL, NULL, NULL, NULL, 'admin', '2025-06-14 11:32:56', '2025-06-14 11:32:56'),
(5, 'buyer_john', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Doe', '086 178 7737', '321 Main St', 'Cape Town', 'WC', '8001', 'buyer', '2025-06-14 11:32:56', '2025-06-14 11:32:56'),
(6, 'shopper_alice', 'alice@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alice', 'Brown', '011 475 4107', '654 Oak Ave', 'Roodepoort', 'GP', '1724', 'buyer', '2025-06-14 11:32:56', '2025-06-14 11:32:56'),
(7, 'customer_bob', 'bob@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bob', 'Davis', '021 433 1663', '987 Pine St', 'Cape Town', 'WC', '7441', 'buyer', '2025-06-14 11:32:56', '2025-06-14 11:32:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_product` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
