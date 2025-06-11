<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
requireRole("admin");
$orders = getOrders();
?>

<div class="admin-container">

    <?php if (empty($orders)) { ?>
        <p>No orders found.</p>
    <?php } else { ?>
        <?php foreach ($orders as $order) { ?>
            <div class="admin-item">
                <form action="" method="POST">
                    <div class="admin-item-body">
                        <h5 class="card-title"><?php echo "Order #{$order['id']}" ?></h5>
                        <p class="card-text"><?php echo "By {$order['first_name']} {$order['last_name']}" ?></p>
                        <p class="card-text"><?php echo "To {$order['shipping_address']}" ?></p>
                        <p class="card-text"><?php echo formatPrice($order['total_price']) ?></p>
                        <div class="admin-buttons">
                            <a href="./order.php?request=edit&id=<?php echo urlencode($order['id']); ?>" class="btn btn-success btn-lg">Edit</a>
                            <a href="./order.php?request=delete&id=<?php echo urlencode($order['id']); ?>" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>

    <?php } ?>
</div>
<?php
require_once '../includes/footer.php';
?>