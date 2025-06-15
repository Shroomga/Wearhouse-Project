<?php
require_once __DIR__ . '/../config/database.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Authentication
function isLoggedIn()
{
    return !empty($_SESSION['user_id']);
}
//send to login screen if not logged in.
function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
}
//first send to login screen if not logged in.
//Once logged in, check if the role they have matches the role
//we want them to have. If it's not, send them to the unauthorized 400 code screen.
function requireRole($role)
{
    requireLogin();
    if ($_SESSION['user_role'] !== $role) {
        header('Location: /unauthorized.php');
        exit();
    }
}
//restrict regular users access.
function requireAdminOrSeller()
{
    requireLogin();
    if (!in_array($_SESSION['user_role'], ['admin', 'seller'])) {
        header('Location: /unauthorized.php');
        exit();
    }
}

function getCurrentUser()
{
    if (!isLoggedIn()) {
        return null;
    }
    global $db; //takes the $db declared on global range (the one from the included database.php)
    //and copies its reference to local range (inside this function)
    return $db->fetchOne(
        "SELECT * FROM users WHERE id = ?",
        [$_SESSION['user_id']],
        "i"
    );
}

function login($username, $password)
{
    global $db;

    $user = $db->fetchOne(
        "SELECT * FROM users WHERE (username = ? OR email = ?)",
        [$username, $username],
        "ss"
    );

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];

        return true;
    }

    return false;
}

function logout()
{
    // if (isLoggedIn()) {
    //     logSystemAction($_SESSION['user_id'], 'LOGOUT', 'User logged out');
    // }

    session_destroy();
    header('Location: /login.php');
    exit();
}

function register($data)
{
    global $db;

    // Validate required fields
    $required = ['username', 'email', 'password', 'first_name', 'last_name'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            return ['success' => false, 'message' => 'Please fill all required fields.'];
        }
    }

    // Check if username or email already exists
    $existing = $db->fetchOne(
        "SELECT id FROM users WHERE username = ? OR email = ?",
        [$data['username'], $data['email']],
        "ss"
    );

    if ($existing) {
        return ['success' => false, 'message' => 'Username or email already exists'];
    }

    // Hash password
    $passHash = password_hash($data['password'], PASSWORD_DEFAULT);

    // Insert user
    try {
        $db->query(
            "INSERT INTO users (username, email, password, first_name, last_name, phone, address, city, province, zip_code, role) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['username'],
                $data['email'],
                $passHash,
                $data['first_name'],
                $data['last_name'],
                $data['phone'] ?? null,
                $data['address'] ?? null,
                $data['city'] ?? null,
                $data['province'] ?? null,
                $data['zip_code'] ?? null,
                $data['role'] ?? 'buyer'
            ]
        );

        $userId = $db->lastInsertId();
        // logSystemAction($userId, 'REGISTER', 'New user registered');

        return ['success' => true, 'message' => 'Registration successful'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()];
    }
}

// Product Functions

function getProducts($limit = null, $offset = 0, $category_id = null, $search = null, $seller_id = null)
{
    global $db;

    $sql = "SELECT p.*, c.name as category_name, u.username as seller_username, u.first_name as seller_first_name, u.last_name as seller_last_name
            FROM products AS p
            JOIN categories AS c ON p.category_id = c.id 
            JOIN users AS u ON p.seller_id = u.id 
            WHERE p.status = 'active'";

    $params = [];
    //if there's no category selected,show all products.
    //If there is a category, run the below code to find only products from a category.
    if ($category_id) {
        $sql .= " AND c.parent_id = ? OR c.id = ?";
        $params = array_merge($params, [$category_id, $category_id]);
    }

    if ($search) {
        $sql .= " AND (p.name LIKE ? OR p.description LIKE ? OR p.brand LIKE ?)";
        $searchTerm = "%{$search}%"; //wrap in wildcards for sql LIKE
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
        // if we do have a search term, merge the array for the 3 search parameters (name/description/brand) to params.
    }

    if ($seller_id) {
        //.= is string concatenation
        $sql .= " AND p.seller_id = ?";
        $params[] = $seller_id;
        //if we are sorting by seller, we will add this to our params as well.
    }

    $sql .= " ORDER BY p.created_at DESC";

    if ($limit) {
        //if we want to only get a certain number of rows
        //Or we want to start at a certain row
        //We can add a limit/offset.
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
    }

    return $db->fetchAll($sql, $params);
}

function getProductById($id)
{
    global $db;

    return $db->fetchOne(
        "SELECT p.*, c.name as category_name, u.username as seller_username, u.first_name as seller_first_name, u.last_name as seller_last_name
         FROM products AS p 
         JOIN categories AS c ON p.category_id = c.id 
         JOIN users AS u ON p.seller_id = u.id 
         WHERE p.id = ?",
        [$id],
        'i'
    );
}

function getTitle($category_id = null, $search = null, $seller_id = null)
{
    global $db;
    $title = "Showing results for ";
    if ($category_id) {
        $result = $db->fetchOne("SELECT * FROM categories WHERE id = ?", [$category_id], 'i');
        if ($result) {
            return $title . $result["name"];
        } else {
            return "Category not available.";
        }
    }
    if ($search) {
        $sql = "SELECT p.name AS product_name, p.description AS product_description, p.brand 
                AS product_brand, c.name as category_name, u.username as seller_username
            FROM products AS p
            JOIN categories AS c ON p.category_id = c.id 
            JOIN users AS u ON p.seller_id = u.id 
            WHERE p.status = 'active' AND (p.name LIKE ? OR p.description LIKE ? OR p.brand LIKE ?)";
        $searchTerm = "%{$search}%";
        $params = [$searchTerm, $searchTerm, $searchTerm];
        $result = $db->fetchOne($sql, $params);
        if ($result) {
            return $title . "'{$search}'" ?? null;
        } else {
            return "No items were found for your search.";
        }
    }
    if ($seller_id) {
        $result = $db->fetchOne('SELECT * FROM users WHERE id = ?', [$seller_id], 'i');
        if ($result) {
            return $title . $result["username"];
        }else{
            return "Seller was not found.";
        }
    }
    return $title . "All Products.";
}

function addToCart($user_id, $product_id, $quantity = 1)
{
    global $db;

    try {
        // Check if item already in cart
        $existing = $db->fetchOne(
            "SELECT * FROM cart WHERE user_id = ? AND product_id = ?",
            [$user_id, $product_id],
            'ii'
        );

        if (!empty($existing)) {
            // Update quantity
            $db->query(
                "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?",
                [$quantity, $user_id, $product_id],
                'iii'
            );
        } else {
            // Insert new item
            $db->query(
                "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)",
                [$user_id, $product_id, $quantity],
                'iii'
            );
        }

        return ['success' => true, 'message' => 'Item added to cart'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Failed to add item to cart'];
    }
}

function getCartItems($user_id)
{
    global $db;

    return $db->fetchAll(
        "SELECT c.*, p.name, p.price, p.image_url, p.stock_quantity, u.username AS seller_username
         FROM cart AS c 
         JOIN products AS p ON c.product_id = p.id 
         JOIN users AS u ON p.seller_id = u.id 
         WHERE c.user_id = ? AND p.status = 'active'
         ORDER BY c.added_at DESC",
        [$user_id],
        'i'
    );
}

function removeFromCart($user_id, $product_id)
{
    global $db;

    return $db->query(
        "DELETE FROM cart WHERE user_id = ? AND product_id = ?",
        [$user_id, $product_id],
        'ii'
    );
}

function getCartTotal($user_id)
{
    global $db;

    $result = $db->fetchOne(
        "SELECT SUM(c.quantity * p.price) as total 
         FROM cart AS c 
         JOIN products AS p ON c.product_id = p.id 
         WHERE c.user_id = ? AND p.status = 'active'",
        [$user_id]
    );

    return $result['total'] ?? 0;
    //if there's an existing cart with an existing total value, output that
    //else, output 0
}

function updateCartQuantity($user_id, $product_id, $quantity) {
    global $db;
    $db->query("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?", [$quantity, $user_id, $product_id], 'iii');
}

// Order Functions

function createOrder($buyer_id, $shipping_address, $billing_address, $payment_method)
{
    global $db;

    try {

        // Get cart items
        $cartItems = getCartItems($buyer_id);
        if (empty($cartItems)) {
            throw new Exception('Cart is empty');
        }

        // Calculate total
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        // Create order
        $db->query(
            "INSERT INTO orders (buyer_id, total_amount, shipping_address, payment_method) 
             VALUES (?, ?, ?, ?)",
            [$buyer_id, $total, $shipping_address, $payment_method],
            'idss'
        );

        $orderId = $db->lastInsertId();

        // Create order items
        foreach ($cartItems as $item) {
            $db->query(
                "INSERT INTO order_items (order_id, product_id, seller_id, quantity, price, total) 
                 VALUES (?, ?, ?, ?, ?, ?)",
                [
                    $orderId,
                    $item['product_id'],
                    $item['seller_id'],
                    $item['quantity'],
                    $item['price'],
                    $item['quantity'] * $item['price']
                ],
                'iiiidd'
            );

            // Update product stock
            $db->query(
                "UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?",
                [$item['quantity'], $item['product_id']],
                'ii'
            );
        }

        // Clear cart
        $db->query("DELETE FROM cart WHERE user_id = ?", [$buyer_id], 'i');
        return ['success' => true, 'order_id' => $orderId];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

function getOrders(){
    global $db;
    $sql = "SELECT o.*, u.first_name, u.last_name, u.username
            FROM orders AS o
            JOIN users AS u ON o.buyer_id = u.id";
    $result = $db->fetchAll($sql);
    return $result;
}

// Category Functions

function getCategories($parent_id = null)
{
    global $db;

    $sql = "SELECT * FROM categories";
    $params = [];

    //If we only want to get main categories, the sql will be concatenated with IS NULL for parent_id 
    if ($parent_id === null) {
        $sql .= " WHERE parent_id IS NULL";
    } else {
        //otherwise, we'll bring up all the subcategories of a specific main category.
        $sql .= " AND parent_id = ?";
        $params[] = $parent_id;
    }

    $sql .= " ORDER BY name";

    return $db->fetchAll($sql, $params);
}

function getCategoryById($id)
{
    global $db;

    return $db->fetchOne("SELECT * FROM categories WHERE id = ?", [$id], "i");
}


// Utility Functions

function sanitizeInput($data)
{
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
        //runs callback function (this function) on each item of an array, if it is one.
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function formatPrice($price)
{
    return 'R' . number_format($price, 2, '.', '');
}

function formatDate($date)
{
    return date('Y M j', strtotime($date));
}

function formatDateTime($datetime)
{
    return date('Y M j g:i A', strtotime($datetime));
}

function showMessage($message, $type = 'info')
{
    $_SESSION['flash_message'] = [
        'text' => $message,
        'type' => $type
    ];
}

function setFlashMessage($message, $type = 'info')
{
    $_SESSION['flash_message'] = [
        'text' => $message,
        'type' => $type
    ];
}

function getFlashMessage()
{
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}
//default destination folder is uploads/products/
function uploadImage($file, $destination_folder = 'uploads/products/')
{
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return ['success' => false, 'message' => 'No file uploaded'];
    }

    //checks the type of the upload against array of MIME types
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed_types)) {
        return ['success' => false, 'message' => 'Invalid file type'];
    }

    $max_size = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $max_size) {
        return ['success' => false, 'message' => 'File too large'];
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $filepath = $destination_folder . $filename;

    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755, true);
    }

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return ['success' => true, 'filename' => $filename, 'filepath' => $filepath];
    } else {
        return ['success' => false, 'message' => 'Failed to upload file'];
    }
}
