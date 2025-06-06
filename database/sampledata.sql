-- Sample Products Data
INSERT INTO products (seller_id, category_id, name, description, price, stock_quantity, size, color, brand, image_url, status) VALUES
-- Men's Clothing
(2, 6, 'Classic Blue Denim Jeans', 'High-quality men\'s denim jeans with classic fit', 89.99, 15, '32W x 34L', 'Blue', 'Levi\'s', 'images/products/mens-jeans-1.jpg', 'active'),
(2, 6, 'Vintage Cotton T-Shirt', 'Comfortable vintage-style cotton t-shirt', 24.99, 25, 'L', 'White', 'Hanes', 'images/products/mens-tshirt-1.jpg', 'active'),
(3, 8, 'Leather Bomber Jacket', 'Genuine leather bomber jacket for men', 299.99, 5, 'M', 'Black', 'Calvin Klein', 'images/products/mens-jacket-1.jpg', 'active'),
(2, 6, 'Slim Fit Chinos', 'Modern slim fit chino pants', 65.99, 20, '30W x 32L', 'Khaki', 'Dockers', 'images/products/mens-chinos-1.jpg', 'active'),

-- Women's Clothing
(3, 9, 'Floral Summer Dress', 'Beautiful floral print summer dress', 79.99, 12, 'M', 'Pink', 'Zara', 'images/products/womens-dress-1.jpg', 'active'),
(4, 10, 'Silk Blouse', 'Elegant silk blouse for professional wear', 89.99, 8, 'S', 'Cream', 'Express', 'images/products/womens-blouse-1.jpg', 'active'),
(3, 11, 'High-Waisted Jeans', 'Trendy high-waisted skinny jeans', 69.99, 18, '28W x 30L', 'Dark Blue', 'American Eagle', 'images/products/womens-jeans-1.jpg', 'active'),
(4, 9, 'Little Black Dress', 'Classic little black dress for evening wear', 129.99, 6, 'L', 'Black', 'Ann Taylor', 'images/products/womens-dress-2.jpg', 'active'),

-- Shoes
(2, 12, 'White Canvas Sneakers', 'Classic white canvas sneakers', 59.99, 30, '9', 'White', 'Converse', 'images/products/sneakers-1.jpg', 'active'),
(3, 13, 'Oxford Dress Shoes', 'Men\'s leather oxford dress shoes', 149.99, 10, '10', 'Brown', 'Cole Haan', 'images/products/dress-shoes-1.jpg', 'active'),
(4, 14, 'Ankle Boots', 'Women\'s leather ankle boots', 119.99, 15, '8', 'Black', 'Steve Madden', 'images/products/ankle-boots-1.jpg', 'active'),
(2, 12, 'Running Sneakers', 'Performance running sneakers', 129.99, 22, '9.5', 'Blue', 'Nike', 'images/products/running-shoes-1.jpg', 'active'),

-- Accessories
(3, 15, 'Leather Handbag', 'Genuine leather handbag with multiple compartments', 189.99, 7, 'One Size', 'Brown', 'Coach', 'images/products/handbag-1.jpg', 'active'),
(4, 16, 'Silver Necklace', 'Sterling silver chain necklace', 45.99, 20, 'One Size', 'Silver', 'Pandora', 'images/products/necklace-1.jpg', 'active'),
(2, 17, 'Digital Watch', 'Modern digital sports watch', 199.99, 12, 'One Size', 'Black', 'Casio', 'images/products/watch-1.jpg', 'active'),
(3, 15, 'Canvas Backpack', 'Durable canvas backpack for daily use', 49.99, 25, 'One Size', 'Navy', 'Jansport', 'images/products/backpack-1.jpg', 'active');

-- Sample Orders
INSERT INTO orders (buyer_id, total_price, shipping_address, payment_method, order_status, payment_status, order_date) VALUES
(5, 2789.64, '21 Adderley St, Cape Town, 8001', 'Credit Card', 'delivered', 'paid', '2024-01-15 10:30:00'),
(6, 1619.82, '55 Loop St, Cape Town, 8001', 'PayPal', 'shipped', 'paid', '2024-01-18 14:20:00'),
(7, 4499.64, '101 Florida Rd, Durban, 4001', 'Credit Card', 'processing', 'paid', '2024-01-20 09:45:00'),
(5, 1439.82, '21 Adderley St, Cape Town, 8001', 'Credit Card', 'confirmed', 'paid', '2024-01-22 16:15:00'),
(6, 5759.46, '55 Loop St, Cape Town, 8001', 'Credit Card', 'pending', 'pending', '2024-01-23 11:00:00');

-- Sample Order Items
INSERT INTO order_items (order_id, product_id, seller_id, quantity, price, total) VALUES
-- Order 1 (John's order)
(1, 1, 1, 1, 1619.82, 1619.82),
(1, 9, 2, 1, 1079.82, 1079.82),
(1, 2, 2, 1, 449.82, 449.82),

-- Order 2 (Alice's order)
(2, 1, 1, 1, 1619.82, 1619.82),

-- Order 3 (Bob's order)
(3, 3, 2, 1, 5399.82, 5399.82),
(3, 10, 3, 1, 2699.82, 2699.82),

-- Order 4 (John's second order)
(4, 5, 2, 1, 1439.82, 1439.82),

-- Order 5 (Alice's second order)
(5, 13, 2, 1, 3419.82, 3419.82),
(5, 15, 2, 1, 3599.82, 3599.82),
(5, 8, 4, 1, 2339.82, 2339.82);

-- Sample Transactions
INSERT INTO transactions (order_id, seller_id, buyer_id, amount, commission, net_amount, transaction_type, status, transaction_date) VALUES
(1, 1, 5, 2789.64, 279.00, 2510.64, 'sale', 'completed', '2024-01-15 10:30:00'),
(2, 1, 6, 1619.82, 162.00, 1457.82, 'sale', 'completed', '2024-01-18 14:20:00'),
(3, 2, 7, 4499.64, 450.00, 4049.64, 'sale', 'completed', '2024-01-20 09:45:00'),
(4, 2, 5, 1439.82, 144.00, 1295.82, 'sale', 'completed', '2024-01-22 16:15:00');

-- Sample Messages
INSERT INTO messages (receiver_id, product_id, subject, message, is_read, created_at) VALUES
(1, 1, 'Question about sizing', 'Hi, do these jeans run true to size? I usually wear 32x34.', TRUE, '2024-01-10 09:15:00'),
(5, 1, 'Re: Question about sizing', 'Yes, they run true to size. The 32x34 should fit you perfectly!', TRUE, '2024-01-10 10:30:00'),
(2, 5, 'Interested in the dress', 'Is this dress available in size Small?', FALSE, '2024-01-23 14:20:00'),
(3, 8, 'Delivery question', 'When can you ship this item?', FALSE, '2024-01-23 16:45:00');

-- Add some items to shopping carts
INSERT INTO cart (user_id, product_id, quantity, added_at) VALUES
(5, 7, 1, '2024-01-23 15:30:00'),
(5, 14, 1, '2024-01-23 15:32:00'),
(6, 4, 2, '2024-01-23 16:15:00'),
(7, 11, 1, '2024-01-23 17:20:00'),
(7, 16, 1, '2024-01-23 17:22:00'); 