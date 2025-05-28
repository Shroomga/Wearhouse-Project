<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $login = true;
    }
        
?>

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
        <?php if(empty($login)){ ?>
        <h1>Login</h1>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="Password">
            <input type="submit" name="login" value="Login">
        </form>
        <p>Haven't made an account yet? <a href="./register.php">Register</a></p>
        <?php }else{?>
            <p>Login successful! Continue to <a href="../views/store.html">shop</a></p>
        <?php }?>
    </div>
</body>
</html>

