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

<?php
require_once '../includes/footer.php';
?>