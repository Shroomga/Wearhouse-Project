<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
$category_id = $_GET["category"] ?? null;
$search = $_GET["search"] ?? null;
$seller_id = $_GET["seller_id"] ?? null;
$products = getProducts(null,null,$category_id,$search,$seller_id);
?>

<section class="banner-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold"><?php echo getTitle($category_id, $search, $seller_id)?></h1>
            </div>
            <div class="col-lg-6 text-center">
            </div>
        </div>
    </div>
</section>

<section class="product-grid">
<div class="row">
    <?php foreach ($products as $product) { ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card product-card h-100">
                <div class="position-relative">
                    <?php //echo var_dump($product['image_url']);?>
                    <img src="<?php echo  $product['image_url'] ? '/uploads/' . $product['image_url']  :  '/assets/images/placeholder-product.svg'; ?>"
                        class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">


                    <?php if (isLoggedIn() && $_SESSION['user_role'] !== 'admin') { ?>
                        <button class="btn btn-outline-light btn-sm position-absolute top-0 end-0 m-2 wishlist-btn"
                            data-product-id="<?php echo $product['id']; ?>">
                            <i class="far fa-heart"></i>
                        </button>
                    <?php } ?>
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h6>
                    <p class="text-muted small mb-2">by <?php echo htmlspecialchars($product['seller_first_name'] . ' ' . $product['seller_last_name']); ?></p>

                    <div class="d-flex align-items-center mb-2">
                    </div>

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

                        <div class="d-grid gap-2">
                            <a href="/product.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                            <?php if (isLoggedIn() && $_SESSION['user_role'] === 'buyer' && $product['stock_quantity'] > 0) { ?>
                                <button class="btn btn-primary btn-sm add-to-cart-btn"
                                    data-product-id="<?php echo $product['id']; ?>">
                                    <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                </button>
                            <?php } elseif (!isLoggedIn()) { ?>
                                <a href="./login.php" class="btn btn-primary btn-sm">
                                    <i class="fas fa-sign-in-alt me-1"></i>Login to Buy
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

</section>


<?php
require_once '../includes/footer.php';
?>