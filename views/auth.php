<?php
    $username = $_POST["username"];
    $password = $_POST["password"];
    if(!empty($_POST["register"])){
        $confirm = $_POST["confirm"];
        
        header("./views/login.php");
    }
    if(!empty($_POST["login"])){
        header("./views/store.html");
    }
?>