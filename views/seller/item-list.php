<?php
    include("database.php");
    session_start();
    $id = $_SESSION["userID"];
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
        $result = mysqli_query($conn, "SELECT * FROM items
                                WHERE items.userID = '$id'");
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
    <title>Document</title>
</head>
<body>
    <h1>Your items.</h1>
    <div>
        <div>
            <?php foreach ($items as $item){ ?>
            <div>
                <img alt="some image meant to be here">
            </div>
            <div>
                <h2><?php echo $item->get_name();?></h2>
                <p><?php echo $item->get_price();?></p>
                <a>View description</a> <!--May or may not be replaced with a button that triggers some javascript behaviour instead -->
                <button>Remove item</button>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>

<?php
    mysqli_close($conn);
?>