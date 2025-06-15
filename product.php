<?php
require_once 'includes/header.php';
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
?>

<div class="container">
    <div class="row">
        <div class="col">
            <img src="<?php echo $product['image_url'] ? '/uploads/' . $product['image_url'] : '/assets/images/placeholder-product.svg'; ?>" class="product-detail-img">
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
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>