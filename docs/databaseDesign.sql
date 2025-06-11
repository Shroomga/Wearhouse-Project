-- Users table (buyers, sellers, admins)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(80) UNIQUE NOT NULL,
    email VARCHAR(125) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(60),
    province VARCHAR(50),
    zip_code VARCHAR(10),
    role ENUM('buyer', 'seller', 'admin') DEFAULT 'buyer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Categories table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    parent_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Products table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    seller_id INT NOT NULL,
    category_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT DEFAULT 0,
    color VARCHAR(50),
    brand VARCHAR(100),
    image_url VARCHAR(255),
    size VARCHAR(40),
    status ENUM('active', 'inactive', 'sold') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE, 
    /*delete all products associated with seller when seller is deleted*/
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT 
    /*prevent categories from being deleted as long as there are still products*/
);

-- Orders table
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    buyer_id INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    shipping_address TEXT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    order_status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    shipped_date TIMESTAMP NULL,
    delivered_date TIMESTAMP NULL,
    FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order Items table
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    seller_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Shopping Cart table
CREATE TABLE cart (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
);

-- Transactions table for financial tracking
CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    seller_id INT NOT NULL,
    buyer_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    commission DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    net_amount DECIMAL(10,2) NOT NULL,
    transaction_type ENUM('sale', 'refund') DEFAULT 'sale',
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Messages table for communication to users for notices
CREATE TABLE messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    receiver_id INT NOT NULL,
    product_id INT,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- Insert default categories
INSERT INTO categories (name, description) VALUES
('Men\'s Clothing', 'Clothing items for men'),
('Women\'s Clothing', 'Clothing items for women'),
('Shoes', 'Footwear for all genders'),
('Accessories', 'Fashion accessories'),
('Sportswear', 'Athletic and sports clothing');

-- Insert subcategories
INSERT INTO categories (name, description, parent_id) VALUES
('T-Shirts', 'Men\'s T-shirts', 1),
('Jeans', 'Men\'s jeans and denim pants', 1),
('Jackets', 'Men\'s jackets and coats', 1),
('Dresses', 'Women\'s dresses', 2),
('Tops', 'Women\'s tops and blouses', 2),
('Pants', 'Women\'s pants and trousers', 2),
('Sneakers', 'Casual sneakers', 3),
('Boots', 'Boots for all occasions', 3),
('Bags', 'Handbags and backpacks', 4),
('Jewelry', 'Fashion jewelry', 4),
('Keychains', 'Keychain apparel', 4),
('Watches', 'Wrist watches', 4);

-- Create sample sellers
INSERT INTO users (username, email, password, first_name, last_name, phone, address, city, province, zip_code, role) VALUES
/*password is fashionjane*/
('fashionista_jane', 'jane@example.com', '$2a$12$Fh6Q9rahTAQwCx/W3d3EmO3zZcwrK4mk0tpp.NL7VxUtaomLuX1kK', 'Jane', 'Smith', '086 129 2966', '123 Fashion St', 'Johannesburg', 'GP', '2000', 'seller'),
/*password is mansKevin*/
('kevin_the_man', 'kevin@example.com', '$2a$12$EeB.YR2CPMQHiF/yybRKlOXb2me1.5lIcpmy4vumZa6Q6TMf0Sqdy', 'Kevin', 'Johnson', '011 782 0911', '456 Style Ave', 'Johannesburg', 'GP', '2000', 'seller'),
/*password is ItsSooSue*/
('sweet_sue', 'sue@example.com', '$2a$12$l3OhNvJGwfABT.GNX4uj8ejbS8YwBCEhLAZg2/bXKn0WBxTCdJs7C', 'Sue', 'Wilson', '028 514 1812', '789 Trend Blvd', 'Durban', 'KZN', '4001', 'seller');

-- Create admin user
/*password is password*/
INSERT INTO users (username, email, password, first_name, last_name, role) VALUES
('admin', 'admin@wearhouse.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System', 'Administrator', 'admin');

-- Create sample buyers

/*passwords are all password*/
INSERT INTO users (username, email, password, first_name, last_name, phone, address, city, province, zip_code, role) VALUES
('buyer_john', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Doe', '086 178 7737', '321 Main St', 'Cape Town', 'WC', '8001', 'buyer'),
('shopper_alice', 'alice@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alice', 'Brown', '011 475 4107', '654 Oak Ave', 'Roodepoort', 'GP', '1724', 'buyer'),
('customer_bob', 'bob@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bob', 'Davis', '021 433 1663', '987 Pine St', 'Cape Town', 'WC', '7441', 'buyer'); 

ALTER TABLE products
ADD size varchar(40);