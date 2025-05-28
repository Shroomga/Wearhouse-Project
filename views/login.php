<?php
    include("../database.php");
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $loggedIn = false;
    try {
        $result = mysqli_query($conn, "SELECT * FROM users
                            WHERE users.username = '$username'");
        if(mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)) {
            $type = $row["type"];
            $passHash = $row["password"];
            if(password_verify($password, $passHash)){
                $loggedIn = true;
            }else{
                $loggedIn = false;
            }
            }
            }else{
                //User was not found
            }                 
    } catch (mysqli_sql_exception $err) {
        $error = $err.getSqlState();
        $loggedIn = false;
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
        <?php if(empty($loggedIn)){ ?>
        <h1>Login</h1>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="Password">
            <input type="submit" name="login" value="Login">
        </form>
        <?php if(!empty($error)){ echo "<p>{$error}</p>"; }?>
        <p>Haven't made an account yet? <a href="./register.php">Register</a></p>
        <?php }else{?>
            <p>Login successful! Continue to <a href="../views/store.html">shop</a></p>
        <?php }?>
    </div>
</body>
</html>

<?php
    mysqli_close($conn);
        
?>