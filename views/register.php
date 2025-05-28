<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/styles/auth.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="Password">
            <input type="text" name="confirm" placeholder="Confirm password">
            <input type="submit" name="register" value="Register">
        </form>
        <p>Already have an account? <a href="./login.php">Login</a></p>
    </div>
</body>
</html>

<?php
    $username = $_POST["username"];
    $password = $_POST["password"];
    header("../views/login.php");
?>