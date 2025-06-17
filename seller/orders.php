<?php 
    require_once "../includes/functions.php";
    require_once "../config/config.php";
    require_once "../includes/header.php";

    // Ensure user is logged in and is a seller
    requireRole('seller');

    // Function to update order status based on its items
    function updateOrderStatus($order_id) {
        global $db;
        
        // Get all order items for this order
        $order_items = $db->fetchAll(
            "SELECT order_status FROM order_items WHERE order_id = ?",
            [$order_id],
            "i"
        );
        
        if (empty($order_items)) {
            return;
        }
        
        $all_shipped = true;
        $all_confirmed = true;
        $has_processing = false;
        
        foreach ($order_items as $item) {
            if ($item['order_status'] !== 'shipped') {
                $all_shipped = false;
            }
            if ($item['order_status'] !== 'confirmed') {
                $all_confirmed = false;
            }
            if (in_array($item['order_status'], ['confirmed', 'shipped'])) {
                $has_processing = true;
            }
        }
        
        // Determine the new order status
        $new_status = 'pending';
        if ($all_shipped) {
            $new_status = 'shipped';
        } elseif ($all_confirmed) {
            $new_status = 'confirmed';
        } elseif ($has_processing) {
            $new_status = 'processing';
        }
        
        // Update the order status
        $db->query(
            "UPDATE orders SET order_status = ? WHERE id = ?",
            [$new_status, $order_id],
            "si"
        );
    }

    // Handle order status updates
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action']) && isset($_POST['order_item_id'])) {
            $order_item_id = (int)$_POST['order_item_id'];
            $action = $_POST['action'];
            
            // Verify the order item belongs to this seller
            $order_item = $db->fetchOne(
                "SELECT oi.*, o.id as order_id
                 FROM order_items oi 
                 JOIN orders o ON oi.order_id = o.id 
                 WHERE oi.id = ? AND oi.seller_id = ?",
                [$order_item_id, $_SESSION['user_id']],
                "ii"
            );
            
            if ($order_item) {
                switch ($action) {
                    case 'confirm':
                        $db->query(
                            "UPDATE order_items SET order_status = 'confirmed' WHERE id = ?",
                            [$order_item_id],
                            "i"
                        );
                        updateOrderStatus($order_item['order_id']);
                        setFlashMessage('Order item confirmed successfully', 'success');
                        break;
                        
                    case 'ship':
                        $current_time = date('Y-m-d H:i:s');
                        $db->query(
                            "UPDATE order_items SET order_status = 'shipped', shipped_date = ? WHERE id = ?",
                            [$current_time, $order_item_id],
                            "si"
                        );
                        
                        // Update order shipped_date if all items are shipped
                        $all_shipped = $db->fetchOne(
                            "SELECT COUNT(*) as total, SUM(CASE WHEN order_status = 'shipped' THEN 1 ELSE 0 END) as shipped
                             FROM order_items WHERE order_id = ?",
                            [$order_item['order_id']],
                            "i"
                        );
                        
                        if ($all_shipped['total'] === $all_shipped['shipped']) {
                            $db->query(
                                "UPDATE orders SET shipped_date = ? WHERE id = ?",
                                [$current_time, $order_item['order_id']],
                                "si"
                            );
                        }
                        
                        updateOrderStatus($order_item['order_id']);
                        setFlashMessage('Order item marked as shipped', 'success');
                        break;
                }
            }
        }
    }

    // Get seller's order items with related information
    $order_items = $db->fetchAll(
        "SELECT oi.*, o.order_date,
                p.name as product_name, p.image_url,
                u.first_name, u.last_name, u.email
         FROM order_items oi
         JOIN orders o ON oi.order_id = o.id
         JOIN products p ON oi.product_id = p.id
         JOIN users u ON o.buyer_id = u.id
         WHERE oi.seller_id = ?
         ORDER BY o.order_date DESC",
        [$_SESSION['user_id']],
        "i"
    );

    // Get seller statistics
    $stats = getSellerStats();
?>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <h2 class="card-text"><?php echo $stats['NumberOfOrders']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <h2 class="card-text"><?php echo $stats['NumberOfCustomers']; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <h4 class="mb-0">Order Management</h4>
        </div>
        <div class="card-body">
            <?php if (empty($order_items)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>No orders found.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order Date</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_items as $item): ?>
                                <tr>
                                    <td><?php echo formatDate($item['order_date']); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $item['image_url'] ? upload("images/products/" . $item['image_url']) : asset('images/placeholder-product.svg'); ?>" 
                                                 alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                                 class="img-thumbnail me-2"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php echo htmlspecialchars($item['product_name']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name']); ?><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($item['email']); ?></small>
                                    </td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo formatPrice($item['price']); ?></td>
                                    <td>
                                        <?php
                                        $status_class = match($item['order_status']) {
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'processing' => 'primary',
                                            'shipped' => 'success',
                                            default => 'secondary'
                                        };
                                        ?>
                                        <span class="badge bg-<?php echo $status_class; ?>">
                                            <?php echo ucfirst($item['order_status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($item['order_status'] === 'pending'): ?>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="order_item_id" value="<?php echo $item['id']; ?>">
                                                <input type="hidden" name="action" value="confirm">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-check me-1"></i>Confirm
                                                </button>
                                            </form>
                                        <?php elseif ($item['order_status'] === 'confirmed'): ?>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="order_item_id" value="<?php echo $item['id']; ?>">
                                                <input type="hidden" name="action" value="ship">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-shipping-fast me-1"></i>Ready for Shipping
                                                </button>
                                            </form>
                                        <?php elseif ($item['order_status'] === 'shipped'): ?>
                                            <span class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>Completed
                                            </span>
                                            <?php if ($item['shipped_date']): ?>
                                                <br>
                                                <small class="text-muted">
                                                    Shipped: <?php echo formatDate($item['shipped_date']); ?>
                                                </small>
                                            <?php endif; ?>
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