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
        <h1>Login</h1>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="Password">
            <input type="submit" name="login" value="Login">
        </form>
        <p>Haven't made an account yet? <a href="./register.php">Register</a></p>
    </div>
</body>
</html>

<?php
    $username = $_POST["username"];
    $password = $_POST["password"];
    header("../views/store.html");
?>