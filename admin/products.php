<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
requireRole("admin");
global $db;
$products = $db->fetchAll("SELECT * FROM products ORDER BY name");
?>

<div class="admin-container">

    <?php if (empty($products)) { ?>
        <p>No products found.</p>
    <?php } else { ?>
        <?php foreach ($products as $product) { ?>
            <div class="admin-item">
                <div class="admin-item-body">
                    <h5 class="card-title"><?php echo $product['name'] ?></h5>
                    <p class="card-text"><?php echo $product['description'] ?></p>
                    <p class="card-text"><?php echo formatPrice($product['price']) ?></p>
                    <div class="admin-buttons">
                        <a href="./product.php?request=edit&id=<?php echo urlencode($product['id']); ?>" class="btn btn-success btn-lg">Edit</a>
                        <a href="./product.php?request=delete&id=<?php echo urlencode($product['id']); ?>" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php } ?>
</div>
<?php
require_once '../includes/footer.php';
?>