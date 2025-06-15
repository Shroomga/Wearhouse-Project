<?php 
    require_once "../includes/functions.php";
    require_once "../config/config.php";
    requireRole("buyer");

    require_once "../includes/header.php";

    // Handle order status updates
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action']) && isset($_POST['order_id'])) {
            $order_id = (int)$_POST['order_id'];
            $action = $_POST['action'];
            
            // Verify the order belongs to this buyer
            $order = $db->fetchOne(
                "SELECT * FROM orders WHERE id = ? AND buyer_id = ?",
                [$order_id, $_SESSION['user_id']],
                "ii"
            );
            
            if ($order) {
                switch ($action) {
                    case 'cancel':
                        if (in_array($order['order_status'], ['pending', 'processing'])) {
                            $db->query(
                                "UPDATE orders SET order_status = 'cancelled' WHERE id = ?",
                                [$order_id],
                                "i"
                            );
                            setFlashMessage('Order cancelled successfully', 'success');
                        }
                        break;
                        
                    case 'deliver':
                        if ($order['order_status'] === 'shipped') {
                            $current_time = date('Y-m-d H:i:s');
                            $db->query(
                                "UPDATE orders SET order_status = 'delivered', delivered_date = ? WHERE id = ?",
                                [$current_time, $order_id],
                                "si"
                            );
                            setFlashMessage('Order marked as delivered', 'success');
                        }
                        break;
                }
            }
        }
    }

    // Get buyer's orders with related information
    $orders = $db->fetchAll(
        "SELECT o.*, 
                GROUP_CONCAT(
                    CONCAT(p.name, ' (', oi.quantity, ')') 
                    SEPARATOR ', '
                ) as items_summary,
                COUNT(oi.id) as total_items,
                SUM(oi.quantity * oi.price) as total_amount
         FROM orders o
         JOIN order_items oi ON o.id = oi.order_id
         JOIN products p ON oi.product_id = p.id
         WHERE o.buyer_id = ?
         GROUP BY o.id
         ORDER BY o.order_date DESC",
        [$_SESSION['user_id']],
        "i"
    );
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="mb-0">My Orders</h4>
        </div>
        <div class="card-body">
            <?php if (empty($orders)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>You haven't placed any orders yet.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order Date</th>
                                <th>Items</th>
                                <th>Total Items</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo formatDate($order['order_date']); ?></td>
                                    <td>
                                        <small><?php echo htmlspecialchars($order['items_summary']); ?></small>
                                    </td>
                                    <td><?php echo $order['total_items']; ?></td>
                                    <td><?php echo formatPrice($order['total_amount']); ?></td>
                                    <td>
                                        <?php
                                        $status_class = match($order['order_status']) {
                                            'pending' => 'warning',
                                            'processing' => 'primary',
                                            'confirmed' => 'info',
                                            'shipped' => 'success',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger',
                                            default => 'secondary'
                                        };
                                        ?>
                                        <span class="badge bg-<?php echo $status_class; ?>">
                                            <?php echo ucfirst($order['order_status']); ?>
                                        </span>
                                        <?php if ($order['shipped_date']): ?>
                                            <br>
                                            <small class="text-muted">
                                                Shipped: <?php echo formatDate($order['shipped_date']); ?>
                                            </small>
                                        <?php endif; ?>
                                        <?php if ($order['delivered_date']): ?>
                                            <br>
                                            <small class="text-muted">
                                                Delivered: <?php echo formatDate($order['delivered_date']); ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (in_array($order['order_status'], ['pending', 'processing'])): ?>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                                <input type="hidden" name="action" value="cancel">
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to cancel this order?');">
                                                    <i class="fas fa-times me-1"></i>Cancel Order
                                                </button>
                                            </form>
                                        <?php elseif ($order['order_status'] === 'shipped'): ?>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                                <input type="hidden" name="action" value="deliver">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check me-1"></i>Mark as Delivered
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
    require_once "../includes/footer.php";
?>