-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: wearhousedb
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_product` (`user_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (1,5,7,1,'2024-01-23 13:30:00'),(2,5,14,1,'2024-01-23 13:32:00'),(3,6,4,2,'2024-01-23 14:15:00'),(4,7,11,1,'2024-01-23 15:20:00'),(5,7,16,1,'2024-01-23 15:22:00');
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Men\'s Clothing','Clothing items for men',NULL,'2025-06-14 11:32:56'),(2,'Women\'s Clothing','Clothing items for women',NULL,'2025-06-14 11:32:56'),(3,'Shoes','Footwear for all genders',NULL,'2025-06-14 11:32:56'),(4,'Accessories','Fashion accessories',NULL,'2025-06-14 11:32:56'),(5,'Sportswear','Athletic and sports clothing',NULL,'2025-06-14 11:32:56'),(6,'T-Shirts','Men\'s T-shirts',1,'2025-06-14 11:32:56'),(7,'Jeans','Men\'s jeans and denim pants',1,'2025-06-14 11:32:56'),(8,'Jackets','Men\'s jackets and coats',1,'2025-06-14 11:32:56'),(9,'Dresses','Women\'s dresses',2,'2025-06-14 11:32:56'),(10,'Tops','Women\'s tops and blouses',2,'2025-06-14 11:32:56'),(11,'Pants','Women\'s pants and trousers',2,'2025-06-14 11:32:56'),(12,'Sneakers','Casual sneakers',3,'2025-06-14 11:32:56'),(13,'Boots','Boots for all occasions',3,'2025-06-14 11:32:56'),(14,'Bags','Handbags and backpacks',4,'2025-06-14 11:32:56'),(15,'Jewelry','Fashion jewelry',4,'2025-06-14 11:32:56'),(16,'Keychains','Keychain apparel',4,'2025-06-14 11:32:56'),(17,'Watches','Wrist watches',4,'2025-06-14 11:32:56');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `receiver_id` (`receiver_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,1,1,'Question about sizing','Hi, do these jeans run true to size? I usually wear 32x34.',1,'2024-01-10 07:15:00'),(2,5,1,'Re: Question about sizing','Yes, they run true to size. The 32x34 should fit you perfectly!',1,'2024-01-10 08:30:00'),(3,2,5,'Interested in the dress','Is this dress available in size Small?',0,'2024-01-23 12:20:00'),(4,3,8,'Delivery question','When can you ship this item?',0,'2024-01-23 14:45:00');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_status` enum('pending','confirmed','delivered') DEFAULT 'pending',
  `shipped_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `seller_id` (`seller_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,1,1,1619.82,1619.82,'delivered','2025-06-15 17:07:03'),(2,1,9,2,1,1079.82,1079.82,'delivered','2025-06-15 17:07:03'),(3,1,2,2,1,449.82,449.82,'delivered','2025-06-15 17:07:03'),(4,2,1,1,1,1619.82,1619.82,'delivered','2025-06-15 17:07:03'),(5,3,3,2,1,5399.82,5399.82,'confirmed',NULL),(6,3,10,3,1,2699.82,2699.82,'confirmed',NULL),(7,4,5,2,1,1439.82,1439.82,'confirmed',NULL),(8,5,13,2,1,3419.82,3419.82,'pending',NULL),(9,5,15,2,1,3599.82,3599.82,'pending',NULL),(10,5,8,4,1,2339.82,2339.82,'pending',NULL);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `order_status` enum('pending','confirmed','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `shipped_date` timestamp NULL DEFAULT NULL,
  `delivered_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buyer_id` (`buyer_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,5,2789.64,'21 Adderley St, Cape Town, 8001','Credit Card','delivered','paid','2024-01-15 08:30:00','2025-06-15 17:07:03',NULL),(2,6,1619.82,'55 Loop St, Cape Town, 8001','PayPal','delivered','paid','2024-01-18 12:20:00','2025-06-15 17:07:03',NULL),(3,7,4499.64,'101 Florida Rd, Durban, 4001','Credit Card','confirmed','paid','2024-01-20 07:45:00',NULL,NULL),(4,5,1439.82,'21 Adderley St, Cape Town, 8001','Credit Card','confirmed','paid','2024-01-22 14:15:00',NULL,NULL),(5,6,5759.46,'55 Loop St, Cape Town, 8001','Credit Card','pending','pending','2024-01-23 09:00:00',NULL,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `seller_id` (`seller_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,6,'Classic Blue Denim Jeans','High-quality men\'s denim jeans with classic fit',89.99,15,'Blue','Levi\'s','images/products/mens-jeans-1.jpg','32W x 34L','active','2025-06-14 11:37:53','2025-06-15 06:17:53'),(2,1,6,'Vintage Cotton T-Shirt','Comfortable vintage-style cotton t-shirt',24.99,25,'White','Hanes','images/products/mens-tshirt-1.jpg','L','active','2025-06-14 11:37:53','2025-06-15 06:18:05'),(3,2,8,'Leather Bomber Jacket','Genuine leather bomber jacket for men',299.99,5,'Black','Calvin Klein','images/products/mens-jacket-1.jpg','M','active','2025-06-14 11:37:53','2025-06-15 06:18:11'),(4,1,6,'Slim Fit Chinos','Modern slim fit chino pants',65.99,20,'Khaki','Dockers','images/products/mens-chinos-1.jpg','30W x 32L','active','2025-06-14 11:37:53','2025-06-15 06:18:14'),(5,2,9,'Floral Summer Dress','Beautiful floral print summer dress',79.99,12,'Pink','Zara','images/products/womens-dress-1.jpg','M','active','2025-06-14 11:37:53','2025-06-15 06:18:17'),(6,3,10,'Silk Blouse','Elegant silk blouse for professional wear',89.99,8,'Cream','Express','images/products/womens-blouse-1.jpg','S','active','2025-06-14 11:37:53','2025-06-15 06:18:22'),(7,2,11,'High-Waisted Jeans','Trendy high-waisted skinny jeans',69.99,18,'Dark Blue','American Eagle','images/products/womens-jeans-1.jpg','28W x 30L','active','2025-06-14 11:37:53','2025-06-15 06:18:27'),(8,3,9,'Little Black Dress','Classic little black dress for evening wear',129.99,6,'Black','Ann Taylor','images/products/womens-dress-2.jpg','L','active','2025-06-14 11:37:53','2025-06-15 06:18:30'),(9,1,12,'White Canvas Sneakers','Classic white canvas sneakers',59.99,30,'White','Converse','images/products/sneakers-1.jpg','9','active','2025-06-14 11:37:53','2025-06-15 06:18:36'),(10,2,13,'Oxford Dress Shoes','Men\'s leather oxford dress shoes',149.99,10,'Brown','Cole Haan','images/products/dress-shoes-1.jpg','10','active','2025-06-14 11:37:53','2025-06-15 06:18:39'),(11,3,14,'Ankle Boots','Women\'s leather ankle boots',119.99,15,'Black','Steve Madden','images/products/ankle-boots-1.jpg','8','active','2025-06-14 11:37:53','2025-06-15 06:18:43'),(12,1,12,'Running Sneakers','Performance running sneakers',129.99,22,'Blue','Nike','images/products/running-shoes-1.jpg','9.5','active','2025-06-14 11:37:53','2025-06-15 06:18:47'),(13,2,15,'Leather Handbag','Genuine leather handbag with multiple compartments',189.99,7,'Brown','Coach','images/products/handbag-1.jpg','One Size','active','2025-06-14 11:37:53','2025-06-15 06:18:50'),(14,3,16,'Silver Necklace','Sterling silver chain necklace',45.99,20,'Silver','Pandora','images/products/necklace-1.jpg','One Size','active','2025-06-14 11:37:53','2025-06-15 06:18:54'),(15,1,17,'Digital Watch','Modern digital sports watch',199.99,12,'Black','Casio','images/products/watch-1.jpg','One Size','active','2025-06-14 11:37:53','2025-06-15 06:18:57'),(16,2,15,'Canvas Backpack','Durable canvas backpack for daily use',49.99,25,'Navy','Jansport','images/products/backpack-1.jpg','One Size','active','2025-06-14 11:37:53','2025-06-15 06:19:01');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('sale','refund') DEFAULT 'sale',
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `seller_id` (`seller_id`),
  KEY `buyer_id` (`buyer_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,1,1,5,2789.64,279.00,2510.64,'sale','completed','2024-01-15 08:30:00'),(2,2,1,6,1619.82,162.00,1457.82,'sale','completed','2024-01-18 12:20:00'),(3,3,2,7,4499.64,450.00,4049.64,'sale','completed','2024-01-20 07:45:00'),(4,4,2,5,1439.82,144.00,1295.82,'sale','completed','2024-01-22 14:15:00');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'fashionista_jane','jane@example.com','$2a$12$Fh6Q9rahTAQwCx/W3d3EmO3zZcwrK4mk0tpp.NL7VxUtaomLuX1kK','Jane','Smith','086 129 2966','123 Fashion St','Johannesburg','GP','2000','seller','2025-06-14 11:32:56','2025-06-14 11:32:56'),(2,'kevin_the_man','kevin@example.com','$2a$12$EeB.YR2CPMQHiF/yybRKlOXb2me1.5lIcpmy4vumZa6Q6TMf0Sqdy','Kevin','Johnson','011 782 0911','456 Style Ave','Johannesburg','GP','2000','seller','2025-06-14 11:32:56','2025-06-14 11:32:56'),(3,'sweet_sue','sue@example.com','$2a$12$l3OhNvJGwfABT.GNX4uj8ejbS8YwBCEhLAZg2/bXKn0WBxTCdJs7C','Sue','Wilson','028 514 1812','789 Trend Blvd','Durban','KZN','4001','seller','2025-06-14 11:32:56','2025-06-14 11:32:56'),(4,'admin','admin@wearhouse.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','System','Administrator',NULL,NULL,NULL,NULL,NULL,'admin','2025-06-14 11:32:56','2025-06-14 11:32:56'),(5,'buyer_john','john@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','John','Doe','086 178 7737','321 Main St','Cape Town','WC','8001','buyer','2025-06-14 11:32:56','2025-06-14 11:32:56'),(6,'shopper_alice','alice@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Alice','Brown','011 475 4107','654 Oak Ave','Roodepoort','GP','1724','buyer','2025-06-14 11:32:56','2025-06-14 11:32:56'),(7,'customer_bob','bob@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Bob','Davis','021 433 1663','987 Pine St','Cape Town','WC','7441','buyer','2025-06-14 11:32:56','2025-06-14 11:32:56');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-15 19:13:13
