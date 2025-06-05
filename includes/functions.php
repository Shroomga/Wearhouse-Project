<?php
require_once __DIR__ . '/../config/database.php';

function login($username, $password)
{
    global $db;

    $result = mysqli_query($db->getConnection(), "SELECT * FROM users
                WHERE username = '$username'");


    if ($result && mysqli_num_rows($result) > 0) {
        while ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user["password"])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];  
            }
        }
        return true;
    }
    return false;
}
