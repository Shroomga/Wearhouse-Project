<?php
    require_once "../includes/functions.php";
    require_once "../config/config.php";
    requireRole("buyer");

    require_once "../includes/header.php";
?>

<section>
    <div class="container">
        <div class="title row-md-12 text-center mt-4">
            <h1>Welcome to the Buyer Dashboard</h1>
        </div>
        <div class="row text-center mt-5">
            <div class="col-md-6">
                <a href="<?php echo url("buyer/orders.php"); ?>" class="btn btn-primary">View Orders</a>
            </div>
            <div class="col-md-6">
                <a href="<?php echo url("buyer/account.php"); ?>" class="btn btn-primary">View Account</a>
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
                <?php
                $user = getCurrentUser();
                if ($user){
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
    require_once "../includes/footer.php";
?>