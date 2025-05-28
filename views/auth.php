<?php
    $username = $_POST["username"];
    $password = $_POST["password"];
    if(!empty($_POST["register"])){
        header("./views/login.php");
    }
    if(!empty($_POST["login"])){
        header("./views/store.html");
    }
?>