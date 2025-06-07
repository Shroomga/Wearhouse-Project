<?php
require_once __DIR__ . '/functions.php';
$current_user = getCurrentUser();
$cart_count = 0;
if (isLoggedIn() && $_SESSION['user_role'] !== 'admin') {
    $cart_items = getCartItems($_SESSION['user_id']);
    $cart_count = array_sum(array_column($cart_items, 'quantity'));
}
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Wearhouse: Wear it Out!'; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-tshirt me-2"></i>Wearhouse
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-th-large me-1"></i>Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($categories as $category) { ?>
                                <li><a class="dropdown-item" href="/views/store.php?category=<?php echo $category['id']; ?>"><?php echo $category['name'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/views/store.php"><i class="fas fa-shopping-bag me-1"></i>All Products</a>
                    </li>
                </ul>

                <!-- Search Form -->
                <form class="d-flex me-3" method="GET" action="/views/store.php">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                </form>

                <ul class="navbar-nav">
                    <?php if (isLoggedIn()) { ?>
                        <?php if ($_SESSION['user_role'] !== 'admin') { ?>
                            <li class="nav-item">
                                <a class="nav-link position-relative" href='/views/cart.php'>
                                    <i class="fas fa-shopping-cart me-1"></i>Cart
                                    <?php if ($cart_count > 0) { ?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            <?php echo $cart_count; ?>
                                        </span>
                                    <?php } ?>
                                </a>
                            </li>
                        <?php } ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($_SESSION['first_name']); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION['user_role'] === 'admin') { ?>
                                    <li><a class="dropdown-item" href="/admin/"><i class="fas fa-cog me-1"></i>Admin Dashboard</a></li>
                                    <li><a class="dropdown-item" href="/admin/account.php"><i class="fas fa-edit me-1"></i>Edit Profile</a></li>
                                <?php } elseif ($_SESSION['user_role'] === 'seller') { ?>
                                    <li><a class="dropdown-item" href="/seller/"><i class="fas fa-store me-1"></i>Seller Dashboard</a></li>
                                    <li><a class="dropdown-item" href="/seller/products.php"><i class="fas fa-boxes me-1"></i>My Products</a></li>
                                    <li><a class="dropdown-item" href="/seller/orders.php"><i class="fas fa-receipt me-1"></i>My Sales</a></li>
                                    <li><a class="dropdown-item" href="/seller/account.php"><i class="fas fa-edit me-1"></i>Edit Profile</a></li>
                                <?php } else { ?>
                                    <li><a class="dropdown-item" href="/buyer/"><i class="fas fa-user me-1"></i>My Account</a></li>
                                    <li><a class="dropdown-item" href="/buyer/orders.php"><i class="fas fa-shopping-bag me-1"></i>My Orders</a></li>
                                    <li><a class="dropdown-item" href="/buyer/account.php"><i class="fas fa-edit me-1"></i>Edit Profile</a></li>
                                <?php } ?>
                                
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/logout.php"><i class="fas fa-sign-out-alt me-1"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register.php"><i class="fas fa-user-plus me-1"></i>Register</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php
    $flash_message = getFlashMessage();
    if ($flash_message) {
        $alert_class = match ($flash_message['type']) {
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            default => 'alert-info'
        };
    ?>
        <div class="container mt-3">
            <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                <i class="fas fa-<?php echo $flash_message['type'] === 'error' ? 'exclamation-triangle' : ($flash_message['type'] === 'success' ? 'check-circle' : 'info-circle'); ?> me-2"></i>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php } ?>

    <main class="flex-grow-1"><?php // Content will be inserted here 
                                ?>
</body>

</html>