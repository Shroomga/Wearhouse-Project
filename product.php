<?php
require_once 'includes/functions.php';
global $db;
$product_id = $_GET["id"];
$product = getProductById($product_id);
$seller = $db->fetchOne(
    "SELECT CONCAT(users.first_name, ' ', users.last_name) AS fullname
                        FROM users
                        JOIN products ON users.id = products.seller_id
                        WHERE products.id = ? AND products.status = 'active'",
    [$product_id]
);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    addToCart($_SESSION['user_id'], $_POST['product_id']);
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="row">
        <div class="col">
            <img src="<?php echo $product['image_url'] ? upload($product['image_url']) : asset('images/placeholder-product.svg'); ?>" class="product-detail-img">
        </div>
        <div class="col">
            <div class="container">
                <h1>
                    <span>
                        <h3><?php echo $product['brand'] ?></h3>
                    </span><?php echo $product['name'] ?? "Product Delisted"; ?>
                </h1>
                <h2><?php echo $seller['fullname'] ?? "Seller unavailable" ?></h2>
                <p><?php echo $product['description'] ?></p>
                <h2><?php echo formatPrice($product['price']) ?></h2>
                <p>Available in: <?php echo $product['color'] ?></p>
                <p>Size: <?php echo $product['size'] ?></p>
                <?php if (isLoggedIn() && $_SESSION['user_role'] === 'buyer' && $product['stock_quantity'] > 0) { ?>
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm add-to-cart-btn"
                            data-product-id="<?php echo $product['id']; ?>">
                            <i class="fas fa-cart-plus me-1"></i>Add to Cart
                        </button>
                    </form>
                <?php } elseif (!isLoggedIn()) { ?>
                    <a href="<?php echo url("login.php") ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-sign-in-alt me-1"></i>Login to Buy
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>