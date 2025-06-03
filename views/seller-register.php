<?php
    include("../database.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Become a seller.</h1>
    <div>
        <?php if($_SESSION["type"] = "user"){ ?>
        <div>
            <p>Use your account to begin selling products.</p>
            <button type="submit" name="confirm">Confirm.</button>
        </div>
        <?php }else{ ?>
            <div>
                <p>Please login to an account before registering as a seller.</p>
                <a>Login.</a>
            </div>
        <?php }?>
    </div>
</body>
</html>

<?php
    if(isset($_POST["confirm"])){
        try {
            $id = $_SESSION["id"];
            mysqli_query($conn, "UPDATE users
                        SET type= 'seller'
                        WHERE users.id = '$id'");
        } catch (mysqli_sql_exception) {
            echo "<p>There was an error</p>";
        }
    }
    mysqli_close($conn);
?>