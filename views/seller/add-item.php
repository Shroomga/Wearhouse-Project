<?php
    include("database.php");
    session_start();
    $id = $_SESSION["userID"];
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST["name"];
        $category = $_POST["category"];
        $description = $_POST["description"];
        $price = $_POST["price"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form>
        <!-- add labels later -->
        <input name="name" type="text" placeholder="Enter your product's name.">
        <select name="category">
            <option value="shirts">Shirts</option>
            <option value="trousers">Trousers</option>
            <option value="hatsAndAccessories">Hats and Accessories</option>
            <option value="jackets">Jackets</option>
            <option value="blouses">Blouses</option>
            <option value="shoes">Shoes</option>
        </select>
        <textarea name="description" rows="4" cols="25" placeholder="Enter description here..."></textarea>
        <input type="text" name="price" placeholder="Price in rands.">
        <input type="submit" value="Add Item">
    </form>
</body>
</html>


<?php
    mysqli_close($conn);
?>