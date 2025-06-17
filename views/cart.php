<?php
require_once '../includes/functions.php';
require_once '../config/database.php';

requireRole('buyer'); // Only buyers should access the cart

// Handle cart actions (increase, decrease, remove)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    $cart_items = getCartItems($_SESSION['user_id']); // Get cart items before processing

    switch(true) {
        case isset($_POST['increase']):
            foreach ($cart_items as $item) {
                if ($item['product_id'] == $product_id && $item['quantity'] < $item['stock_quantity']) {
                    addToCart($_SESSION['user_id'], $product_id, 1);
                    break;
                }
            }
            break;

        case isset($_POST['decrease']):
            foreach ($cart_items as $item) {
                if ($item['product_id'] == $product_id && $item['quantity'] > 1) {
                    updateCartQuantity($_SESSION['user_id'], $product_id, $item['quantity'] - 1);
                    break;
                }
            }
            break;

        case isset($_POST['remove']):
            removeFromCart($_SESSION['user_id'], $product_id);
            break;

        case isset($_POST['quantity']):
            $new_qty = max(1, (int)$_POST['quantity']);
            updateCartQuantity($_SESSION['user_id'], $product_id, $new_qty);
            break;
    }
    
    header("Location: " . url('views/cart.php'));
    exit();
}
require_once '../includes/header.php';
$cart_items = getCartItems($_SESSION['user_id']);
$subtotal = 0;
$commission_rate = 0.10; // 10% commission

?>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2 class="mb-4">
                <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
            </h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <?php if (empty($cart_items)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Your cart is empty.
                    <a href="<?php echo url('views/store.php'); ?>" class="alert-link">Continue shopping</a>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 50%">Product</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-center" style="width: 150px">Quantity</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center" style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_items as $item): 
                                        $item_total = $item['quantity'] * $item['price'];
                                        $subtotal += $item_total;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                        <img src="<?php echo $item['image_url'] ? upload("images/products/" . $item['image_url']) : asset('images/placeholder-product.svg'); ?>" 
                                                            alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                         class="img-thumbnail me-3"
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1"><?php echo htmlspecialchars($item['name']); ?></h6>
                                                        <small class="text-muted d-block">Seller: <?php echo htmlspecialchars($item['seller_username']); ?></small>
                                                        <small class="text-muted d-block">Stock: <?php echo $item['stock_quantity']; ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end"><?php echo formatPrice($item['price']); ?></td>
                                            <td>
                                                <form method="post" class="d-flex align-items-center justify-content-center" style="gap: 5px;">
                                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                                    <button type="submit" name="decrease" class="btn btn-outline-secondary btn-sm" <?php echo $item['quantity'] <= 1 ? 'disabled' : ''; ?>>
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                                           min="1" max="<?php echo $item['stock_quantity']; ?>" 
                                                           class="form-control form-control-sm" style="width: 60px; text-align: center;">
                                                    <button type="submit" name="increase" class="btn btn-outline-secondary btn-sm" <?php echo $item['quantity'] >= $item['stock_quantity'] ? 'disabled' : ''; ?>>
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-end"><?php echo formatPrice($item_total); ?></td>
                                            <td class="text-center">
                                                <form method="post" class="d-inline">
                                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                                    <button type="submit" name="remove" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span><?php echo formatPrice($subtotal); ?></span>
                    </div>
                    <?php $commission = $subtotal * $commission_rate; ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Commission (10%)</span>
                        <span><?php echo formatPrice($commission); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong><?php echo formatPrice($subtotal + $commission); ?></strong>
                    </div>
                    <?php if (!empty($cart_items)): ?>
                        <a href="<?php echo url('views/check-out.php'); ?>" class="btn btn-primary w-100">
                            <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>