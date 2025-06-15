<?php

require_once '../includes/functions.php';
require_once '../config/config.php';
requireRole("seller");
global $db;
$products = $db->fetchOne("SELECT COUNT(id) AS NumberOfProducts FROM products WHERE seller_id = ?", [$_SESSION['user_id']], 'i');
$stats = getSellerStats();

require_once '../includes/header.php';
?>

<section>
    <div class="container">
        <div class="title">
            <h1>Welcome to the Seller Dashboard</h1>
        </div>
    </div>
</section>
<section>
    <div class="container text-center">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customers</h5>
                        <p class="card-text"><?php echo $stats['NumberOfCustomers']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Products</h5>
                        <p class="card-text"><?php echo $products['NumberOfProducts']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders</h5>
                        <p class="card-text"><?php echo $stats['NumberOfOrders']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once '../includes/footer.php';
?>