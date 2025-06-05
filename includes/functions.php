<?php
require_once __DIR__ . '/../config/database.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Authentication
function isLoggedIn() {
    return !empty($_SESSION['user_id']);
}
    //send to login screen if not logged in.
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
}
    //first send to login screen if not logged in.
    //Once logged in, check if the role they have matches the role
    //we want them to have. If it's not, send them to the unauthorized 400 code screen.
function requireRole($role) {
    requireLogin();
    if ($_SESSION['user_role'] !== $role) {
        header('Location: /unauthorized.php');
        exit();
    }
}
    //restrict regular users access.
function requireAdminOrSeller() {
    requireLogin();
    if (!in_array($_SESSION['user_role'], ['admin', 'seller'])) {
        header('Location: /unauthorized.php');
        exit();
    }
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    global $db; //takes the $db declared on global range (the one from the included database.php)
                //and copies its reference to local range (inside this function)
    return $db->fetchOne(
        "SELECT * FROM users WHERE id = ?",
        [$_SESSION['user_id']], "i"
    );
}

function login($username, $password)
{
    global $db;

    $user = $db->fetchOne(
        "SELECT * FROM users WHERE (username = ? OR email = ?) AND status = 'active'",
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

function logout() {
    // if (isLoggedIn()) {
    //     logSystemAction($_SESSION['user_id'], 'LOGOUT', 'User logged out');
    // }
    
    session_destroy();
    header('Location: /login.php');
    exit();
}

function register($data) {
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
        [$data['username'], $data['email']], "ss"
    );
    
    if ($existing) {
        return ['success' => false, 'message' => 'Username or email already exists'];
    }
    
    // Hash password
    $passHash = password_hash($data['password'], PASSWORD_DEFAULT);
    
    // Insert user
    try {
        $db->query(
            "INSERT INTO users (username, email, password, first_name, last_name, phone, address, city, state, zip_code, role) 
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
                $data['state'] ?? null,
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
