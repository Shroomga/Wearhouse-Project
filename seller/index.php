<?php

require_once '../includes/functions.php';
require_once '../config/config.php';
requireRole("seller");
global $db;
$products = $db->fetchOne("SELECT COUNT(id) AS NumberOfProducts FROM products WHERE seller_id = ?", [$_SESSION['user_id']], 'i');
$stats = getSellerStats();
$user = getCurrentUser();
require_once '../includes/header.php';
?>

<section>
    <div class="container my-4 text-center">
        <div class="title">
            <h1>Welcome to the Seller Dashboard</h1>
        </div>
    </div>
</section>
<section>
    <div class="container text-center mt-2">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Customers</h5>
                        <p class="card-text"><?php echo $stats['NumberOfCustomers']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Products</h5>
                        <p class="card-text"><?php echo $products['NumberOfProducts']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-black">
                    <div class="card-body">
                        <h5 class="card-title">Orders</h5>
                        <p class="card-text"><?php echo $stats['NumberOfOrders']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-4">
                <a href="<?php echo url("seller/products.php"); ?>" class="btn btn-primary">View Products</a>
            </div>
            <div class="col-md-4">
                <a href="<?php echo url("seller/orders.php"); ?>" class="btn btn-primary">View Orders</a>
            </div>
            <div class="col-md-4">
                <a href="<?php echo url("seller/account.php"); ?>" class="btn btn-primary">View Account</a>
            </div>
        </div>
    </div>
</section>
<section>
<div class="container py-5">
        <div class="card mt-5">
            <div class="card-header bg-white">
                <h4 class="mb-0">Account Details</h4>
            </div> 
            <div class="card-body">
            <?php if ($user){
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Role:</strong> <?php echo ucfirst(htmlspecialchars($user['role'])); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address'] ?? 'Not provided'); ?></p>
                        <p><strong>City:</strong> <?php echo htmlspecialchars($user['city'] ?? 'Not provided'); ?></p>
                        <p><strong>Postal Code:</strong> <?php echo htmlspecialchars($user['postal_code'] ?? 'Not provided'); ?></p>
                    </div>
                </div>
                <?php } else { ?>
                <div class="alert alert-warning">
                    Unable to load account details.
                </div>
                <?php } ?>
            </div>

        </div>
    </div>
</section>

<?php
require_once '../includes/footer.php';
?>