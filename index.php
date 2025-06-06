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
                    <a href="/views/store.php" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Shop Now
                    </a>
                    <?php if (!isLoggedIn()){ ?>
                    <a href="/register.php?role=seller" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-store me-2"></i>Start Selling
                    </a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="/assets/images/hero-fashion.svg" alt="Fashion Illustration" class="img-fluid" style="max-height: 400px;">
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
                <a href="/views/store.php?category=<?php echo $category['id']; ?>" class="text-decoration-none">
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