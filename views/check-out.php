<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
requireRole('buyer'); // Only buyers should access checkout

// Get cart items
$cart_items = getCartItems($_SESSION['user_id']);
if (empty($cart_items)) {
    header("Location: " . url('views/cart.php'));
    exit;
}

// Calculate totals
$subtotal = 0;
$commission_rate = 0.10; // 10% commission
foreach ($cart_items as $item) {
    $subtotal += $item['quantity'] * $item['price'];
}
$commission = $subtotal * $commission_rate;
$total = $subtotal + $commission;

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $result = createOrder(
        $_SESSION['user_id'],
        $_POST['shipping_address'] ?? 'Default Address', // For demo, using default address
        $_POST['billing_address'] ?? 'Default Address',  // For demo, using default address
        'cash' // For demo, using cash payment
    );
    
    if ($result['success']) {
        header("Location: " . url('buyer/orders.php') . "?order_id=" . $result['order_id']);
        exit;
    } else {
        $error = $result['message'];
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2 class="mb-4">
                <i class="fas fa-credit-card me-2"></i>Checkout
            </h2>
        </div>
    </div>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Items</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart_items as $item): 
                                    $item_total = $item['quantity'] * $item['price'];
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo $item['image_url'] ? asset('uploads/' . $item['image_url']) : asset('images/placeholder-product.svg'); ?>" 
                                                     alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                     class="img-thumbnail me-3"
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                                    <small class="text-muted">Seller: <?php echo htmlspecialchars($item['seller_username']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo formatPrice($item['price']); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td><?php echo formatPrice($item_total); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Payment Method</h5>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>For demonstration purposes, orders will be processed without actual payment.
                    </div>
                    <form method="post" class="mt-4">
                        <button type="submit" name="place_order" class="btn btn-primary">
                            <i class="fas fa-check me-2"></i>Place Order
                        </button>
                        <a href="<?php echo url('views/cart.php'); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Cart
                        </a>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span><?php echo formatPrice($subtotal); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Commission (10%)</span>
                        <span><?php echo formatPrice($commission); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong><?php echo formatPrice($total); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>