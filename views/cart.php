<?php
// Handle cart actions (increase, decrease, remove)
require_once '../includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    if (isset($_POST['increase'])) {
        // Increase quantity by 1
        foreach ($cart_items as $item) {
            if ($item['product_id'] == $product_id && $item['quantity'] < $item['stock_quantity']) {
                addToCart($user_id, $product_id, 1);
                break;
            }
        }
    } elseif (isset($_POST['decrease'])) {
        // Decrease quantity by 1
        foreach ($cart_items as $item) {
            if ($item['product_id'] == $product_id && $item['quantity'] > 1) {
                updateCartQuantity($user_id, $product_id, $item['quantity'] - 1);
                break;
            }
        }
    } elseif (isset($_POST['remove'])) {
        removeFromCart($user_id, $product_id);
    } elseif (isset($_POST['quantity'])) {
        $new_qty = max(1, (int)$_POST['quantity']);
        updateCartQuantity($user_id, $product_id, $new_qty);
    }
    header("Location: cart.php");
    exit;
}
?>

<?php
require_once '../includes/header.php';
requireRole('buyer'); // Only buyers should access the cart

$user_id = $_SESSION['user_id'];
$cart_items = getCartItems($user_id);
$subtotal = 0;
$commission_rate = 0.10; // Example: 10% commission
?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1>Cart</h1>
        </div>
    </div>
    <div class="row cart">
        <div class="col-md-8">
            <form method="post" action="">
                <div class="body">
                    <ul class="body-items list-group">
                        <?php if (empty($cart_items)) { ?>
                            <li class="list-group-item">Your cart is empty.</li>
                        <?php } else { ?>
                            <?php foreach ($cart_items as $item): 
                                $item_total = $item['quantity'] * $item['price'];
                                $subtotal += $item_total;
                            ?>
                            <li class="list-group-item d-flex align-items-center">
                                <img src="<?php echo $item['image_url'] ? '/uploads/' . $item['image_url'] : '/assets/images/placeholder-product.svg'; ?>" style="width:60px;height:60px;object-fit:cover;margin-right:15px;">
                                <div class="flex-grow-1">
                                    <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                                    <span><?php echo formatPrice($item['price']); ?></span>
                                </div>
                                <form method="post" action="" class="d-flex align-items-center" style="gap:5px;">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                    <button type="submit" name="decrease" class="btn btn-outline-secondary btn-sm">-</button>
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock_quantity']; ?>" style="width:50px;text-align:center;">
                                    <button type="submit" name="increase" class="btn btn-outline-secondary btn-sm">+</button>
                                </form>
                                <span style="width:100px;text-align:right;"><?php echo formatPrice($item_total); ?></span>
                                <form method="post" action="" style="margin-left:10px;">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                    <button type="submit" name="remove" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </li>
                            <?php endforeach; ?>
                        <?php } ?>
                    </ul>
                </div>
            </form>
        </div>
        <div class="col-md-4 totals">
            <div class="card p-3">
                <h2>Estimate Total</h2>
                <p>Subtotal: <?php echo formatPrice($subtotal); ?></p>
                <?php $commission = $subtotal * $commission_rate; ?>
                <p>Commission: <?php echo formatPrice($commission); ?></p>
                <p><strong>Total: <?php echo formatPrice($subtotal + $commission); ?></strong></p>
                <?php if (!empty($cart_items)) { ?>
                    <a href="/views/check-out.php" class="btn btn-primary w-100">Proceed to Checkout</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<?php
require_once '../includes/footer.php';
?>