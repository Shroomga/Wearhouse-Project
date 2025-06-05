
<?php
    include("../database.php");
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $registered = false;
        $confirm = $_POST["confirm"];
        if($confirm === $password){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            try{
                $registered = true;
                mysqli_query($conn, "INSERT INTO users (username, password)
                            VALUES('$username', '$hash')");
                
            }catch(mysqli_sql_exception){
                $registered = false;
            }
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
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="confirm" placeholder="Confirm password">
            <input type="submit" name="register" value="Register">
        </form>
        <p>Already have an account? <a href="./login.php">Login</a></p>
        <?php }else{?>
        <p>Registration confirmed! Please continue to <a href="./login.php">login</a></p>
        <?php }?>
    </div>
</body>
</html>

<?php
    mysqli_close($conn);
?>