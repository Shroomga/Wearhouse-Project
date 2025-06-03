<?php
    include("../database.php");
    class Item {
        protected $name;
        protected $category;
        protected $description;
        protected $price;
        

        function __construct($name, $category, $description, $price)
        {
            $this->name = $name;
            $this->category = $category;
            $this->description = $description;
            $this->price = $price;
            
        }
        function get_name() {
        return $this->name;
        }
        function get_category() {
        return $this->category;
        }
        function get_description(){
            return $this->description;
        }
        function get_price() {
        return $this->price;
        }
        
    }
    $items = [];
    try {
        $result = mysqli_query($conn, "SELECT * FROM items");
        if(mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
                $name = $row["name"];
                $category = $row["category"];
                $description = $row["description"];
                $price = $row["price"];
                $items[] = new Item($name, $category, $description, $price);
            }
        }
    } catch (mysqli_sql_exception) {
        echo "SQL Query error encountered";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Wearhouse</title>
    <link rel="stylesheet" href="../public/styles/main.css">
</head>
<body>
    <a href="./seller-register.php">Become a seller</a>
    <div>
        <div>
        <button>Category 1</button>
        <button>Category 2</button>
        <button>Category 3</button>
        <button>Category 4</button>
        </div>
        <!-- If no category was selected, show all items. 
        If a category was selected, display those category items. -->
        <div>
            <?php foreach ($items as $item){ ?>
            <div>
                <form>
                <img src="someimg.png" alt="some image">
                <h2><?php echo $item->get_name();?></h2>
                <p><?php echo $item->get_price();?></p>
                <p><?php echo $item->get_description();?></p>
                <input type="submit" name="add" value="Add to Cart">
                </form>
                <p><a href="./cart.php">Go to Cart</a></p>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>

<?php
    mysqli_close($conn);
?>