<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
requireRole("admin");
global $db;
$products = getProducts();
?>

<section>
    <div class="px-2 py-3">
        <div class="title">
            <h1>Products</h1>
        </div>
    </div>
</section>

<div class="row">
    <?php if (count($products) > 0) { ?>
        <?php foreach ($products as $product) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <img src="<?php echo $product['image_url'] ? upload("images/products/" . $product['image_url']) : asset('images/placeholder-product.svg'); ?>"
                            class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h6>
                        <p class="text-muted small mb-2">by <?php echo htmlspecialchars($product['seller_first_name'] . ' ' . $product['seller_last_name']); ?></p>

                        <div class="product-meta mb-3">
                            <span class="meta-item"><?php echo htmlspecialchars($product['category_name']); ?></span>
                            <span class="meta-item"><?php echo htmlspecialchars($product['brand']); ?></span>
                            <?php if ($product['size']) { ?>
                                <span class="meta-item">Size: <?php echo htmlspecialchars($product['size']); ?></span>
                            <?php } ?>
                        </div>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="product-price"><?php echo formatPrice($product['price']); ?></div>
                                <small class="text-muted"><?php echo $product['stock_quantity']; ?> left</small>
                            </div>

                            <div class="admin-buttons">
                                <a href="<?php echo url("admin/product.php?request=edit&id=" . urlencode($product['id'])); ?>" class="btn btn-success btn-lg">Edit</a>
                                <a href="<?php echo url("admin/product.php?request=delete&id=" . urlencode($product['id'])); ?>" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="col-12">
            <p>No products found</p>
        </div>
    <?php } ?>
</div>
<?php
require_once '../includes/footer.php';
?>