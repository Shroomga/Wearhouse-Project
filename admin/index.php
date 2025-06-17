<?php
require_once '../includes/functions.php';

requireRole("admin");
global $db;
$stats = getAdminStats();
$user = getCurrentUser();
require_once '../includes/header.php';
?>

<section>
    <div class="container my-4 text-center">
        <div class="title">
            <h1>Welcome to the Admin Dashboard</h1>
        </div>
    </div>
</section>
<!-- Data section -->

<section class="data">
    <div class="container text-center data-container">
        <div class="row my-4 justify-content-center">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h4># of Users</h4>
                        <h2><?php echo $stats['NumberOfUsers'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h4># of Sellers</h4>
                        <h2><?php echo $stats['NumberOfSellers'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-black">
                    <div class="card-body">
                        <h4># of Products</h4>
                        <h2><?php echo $stats['NumberOfProducts'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h4># of Orders</h4>
                        <h2><?php echo $stats['NumberOfOrders'] ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Selection Pane -->
<section>
    <div class="container text-center">
        <div class="row">
            <div class="col-md-6">
                <a href="<?php echo url("admin/users.php"); ?>" class="btn btn-primary">View Users</a>
            </div>
            <div class="col-md-6">
                <a href="<?php echo url("admin/products.php"); ?>" class="btn btn-primary">View Products</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <a href="<?php echo url("admin/orders.php"); ?>" class="btn btn-primary">View Orders</a>
            </div>
            <div class="col-md-6">
                <a href="<?php echo url("admin/categories.php"); ?>" class="btn btn-primary">View Categories</a>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container py-5">
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="mb-0">Account Details</h4>
            </div>
            <div class="card-body">
                <?php if ($user) {
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