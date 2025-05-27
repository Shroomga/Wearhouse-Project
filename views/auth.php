<?php
    $username = $_POST["username"];
    $password = $_POST["password"];
    if($username == "Correct"){
        header("Location: ../views/store.html");
        die();
    }else{
        echo 'Nothing to see here';
    }
?>