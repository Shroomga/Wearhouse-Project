<?php
require_once '../includes/functions.php';
requireRole("admin");
$orders = getOrders();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_order_id'])) {
    $delete_order_id = $_POST['delete_order_id'];
    $db->query("DELETE FROM orders WHERE id = ?", [$delete_order_id]);
    header("Location: orders.php");
    exit();
}
require_once '../includes/header.php';
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
                        <!-- <a href="<?php //echo url("admin/order.php?request=edit&id=" . urlencode($order['id'])); ?>" class="btn btn-success btn-lg">Edit</a> -->
                        <!-- <a href="<?php //echo url("admin/order.php?request=delete&id=" . urlencode($order['id'])); ?>" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a> -->
                         <form action="" method="POST">
                            <input type="hidden" name="delete_order_id" value="<?php echo $order['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to delete this order?');">Delete</button>
                         </form>
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