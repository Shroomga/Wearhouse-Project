<?php
$page_title = 'Wearhouse - Wear it Out!';
require_once 'includes/header.php';

// Get featured products (latest 6)
$featured_products = getProducts(6);

// Get categories for showcase
$categories = getCategories();
?>

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold">Welcome to Wearhouse</h1>
                <p class="lead">Get your new fit ready and thrift it out with style!</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?php echo url('views/store.php'); ?>" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Shop Now
                    </a>
                    <?php if (!isLoggedIn()){ ?>
                    <a href="<?php echo url('register.php?role=seller'); ?>" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-store me-2"></i>Start Selling
                    </a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?php echo asset('images/hero-fashion.svg'); ?>" alt="Fashion Illustration" class="img-fluid" style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-card">
                    <div class="stat-number"><?php echo count(getProducts()); ?>+</div>
                    <div class="stat-label">Products Available</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-card">
                    <div class="stat-number">
                        <?php 
                        $sellers = $db->fetchOne("SELECT COUNT(*) as count FROM users WHERE role = 'seller'");
                        echo $sellers['count'];
                        ?>+
                    </div>
                    <div class="stat-label">Active Sellers</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-card">
                    <div class="stat-number">
                        <?php 
                        $orders = $db->fetchOne("SELECT COUNT(*) as count FROM orders WHERE order_status = 'delivered'");
                        echo $orders['count'];
                        ?>+
                    </div>
                    <div class="stat-label">Happy Customers</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-card">
                    <div class="stat-number"><?php echo count($categories); ?>+</div>
                    <div class="stat-label">Categories</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="section-title">Shop by Category</h2>
        <p class="section-subtitle">Find exactly what you're looking for in our organized categories</p>
        
        <div class="row">
            <?php foreach ($categories as $category){ ?>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                <a href="<?php echo url('views/store.php?category=' . $category['id']); ?>" class="text-decoration-none">
                    <div class="card h-100 category-card">
                        <div class="card-body text-center p-4">
                            <div class="category-icon mb-3">
                                <?php
                                $icons = [
                                    "Men's Clothing" => "fas fa-male",
                                    "Women's Clothing" => "fas fa-female",
                                    "Shoes" => "fas fa-shoe-prints",
                                    "Accessories" => "fas fa-gem",
                                    "Sportswear" => "fas fa-running"
                                ];
                                $icon = $icons[$category['name']] ?? 'fas fa-tshirt';
                                ?>
                                <i class="<?php echo $icon; ?> fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                            <p class="card-text text-muted small"><?php echo htmlspecialchars($category['description']); ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php }?>
        </div>
    </div>
</section>

<section class="featured-products bg-light">
    <div class="container">
        <h2 class="section-title">Featured Products</h2>
        <p class="section-subtitle">Check out our latest and most popular items</p>
                <div class="row">
        <?php foreach ($featured_products as $product){ ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <img src="<?php echo $product['image_url'] ? '/uploads/' . $product['image_url'] : '/assets/images/placeholder-product.svg'; ?>" 
                             class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        
                        
                        <?php if (isLoggedIn() && $_SESSION['user_role'] !== 'admin'){ ?>
                        <button class="btn btn-outline-light btn-sm position-absolute top-0 end-0 m-2 wishlist-btn" 
                                data-product-id="<?php echo $product['id']; ?>">
                            <i class="far fa-heart"></i>
                        </button>
                        <?php } ?>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h6>
                        <p class="text-muted small mb-2">by <?php echo htmlspecialchars($product['seller_first_name'] . ' ' . $product['seller_last_name']); ?></p>
                        
                        
                        <div class="product-meta mb-3">
                            <span class="meta-item"><?php echo htmlspecialchars($product['category_name']); ?></span>
                            <span class="meta-item"><?php echo htmlspecialchars($product['brand']); ?></span>
                            <?php if ($product['size']){ ?>
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
                                <?php if (isLoggedIn() && $_SESSION['user_role'] === 'buyer' && $product['stock_quantity'] > 0){ ?>
                                <button class="btn btn-primary btn-sm add-to-cart-btn" 
                                        data-product-id="<?php echo $product['id']; ?>">
                                    <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                </button>
                                <?php }elseif (!isLoggedIn()){ ?>
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

        
        <div class="text-center">
            <a href="views/store.php" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>View All Products
            </a>
        </div>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>