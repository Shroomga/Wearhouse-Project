<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
requireRole("admin");
global $db;
$users = $db->fetchOne("SELECT COUNT(id) AS NumberOfUsers FROM users");
$sellers = $db->fetchOne("SELECT COUNT(id) AS NumberOfSellers FROM users WHERE role = 'seller'");
$products = $db->fetchOne("SELECT COUNT(id) AS NumberOfProducts FROM Products");
$orders = $db->fetchOne("SELECT COUNT(id) AS NumberOfOrders FROM Orders");
?>

<!-- Data section -->

<section class="data">
    <div class="container">
        <div class="row my-4">
            <div class="col-3">
                <h4># of Users</h4>
                <h2><?php echo $users['NumberOfUsers']?></h2>
            </div>
            <div class="col-3">
                <h4># of Sellers</h4>
                <h2><?php echo $sellers['NumberOfSellers']?></h2>
            </div>
            <div class="col-3">
                <h4># of Products</h4>
                <h2><?php echo $products['NumberOfProducts']?></h2>
            </div>
            <div class="col-3">
                <h4># of Orders</h4>
                <h2><?php echo $orders['NumberOfOrders']?></h2>
            </div>
        </div>
    </div>
</section>

<!-- Selection Pane -->
<section>
    <div class="container text-center">
        <div class="row my-4">
            <div class="col-6">
                <a href="./users.php" class="btn btn-primary btn-lg">Modify Users</a>
            </div>
            <div class="col-6">
                <a href="./products.php" class="btn btn-primary btn-lg">Modify Products</a>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-6">
                <a href="./categories.php" class="btn btn-primary btn-lg">Modify Categories</a>
            </div>
            <div class="col-6">
                <a href="./orders.php" class="btn btn-primary btn-lg">View Orders</a>
            </div>
        </div>
    </div>
</section>

<?php
require_once '../includes/footer.php';
?>