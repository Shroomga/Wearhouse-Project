
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirm = $_POST["confirm"];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    if($confirm === $password){
        $registered = true;
    }else{
        $registered = false;
    }
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
        <?php if(empty($registered)){ ?>
        <h1>Register</h1>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="Password">
            <input type="text" name="confirm" placeholder="Confirm password">
            <input type="submit" name="register" value="Register">
        </form>
        <p>Already have an account? <a href="./login.php">Login</a></p>
        <?php }else{?>
        <p>Registration confirmed! Please continue to <a href="./login.php">login</a></p>
        <?php }?>
    </div>
</body>
</html>

