<?php

require_once '../includes/functions.php';
requireAdminOrSeller();
if($_SESSION['user_role'] == 'admin'){
    header("Location: " . url('admin/products.php'));
}
$products = getProducts(30, 0, null, null, $_SESSION['user_id']);
//first 30 products for the user.
require_once '../includes/header.php';
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">My Products</h2>
        <a href="<?php echo url('seller/add-product.php'); ?>" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Add New Product
        </a>
    </div>
</div>

<div class="row">
    <?php foreach ($products as $product) { ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card product-card h-100">
                <div class="position-relative">
                    <img src="<?php echo $product['image_url'] ? upload($product['image_url']) : asset('images/placeholder-product.svg'); ?>"
                        class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">

                    <!-- Delete Button (X) -->
                    <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this product?');" class="position-absolute top-0 end-0 m-2">
                        <input type="hidden" name="delete_product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Product">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
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

                        <div class="d-grid gap-2 mb-2">
                            <a href="<?php echo url('product.php?id=' . $product['id']); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                        </div>
                        <!-- Edit Product Button -->
                        <div class="d-grid gap-2">
                            <a href="<?php echo url('seller/modify-product.php?id=' . $product['id']); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php
// Handle product deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
    $product_id = intval($_POST['delete_product_id']);
    // Only allow deletion if the product belongs to the current seller
    $product = getProductById($product_id);
    if ($product && $product['seller_id'] == $_SESSION['user_id']) {
        deleteProduct($product_id);
        setFlashMessage('Product deleted successfully.', 'success');
        header('Location: ' . url('seller/products.php'));
        exit;
    } else {
        setFlashMessage('You are not authorized to delete this product.', 'error');
    }
}
require_once '../includes/footer.php';
?>