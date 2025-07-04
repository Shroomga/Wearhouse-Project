<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../config/config.php';
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
    <link href="<?php echo asset('css/styles.css'); ?>" rel="stylesheet">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo url('index.php'); ?>">
                <i class="fas fa-tshirt me-2"></i>Wearhouse
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url('index.php'); ?>"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-th-large me-1"></i>Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($categories as $category) { ?>
                                <li><a class="dropdown-item" href="<?php echo url('views/store.php?category=' . $category['id']); ?>"><?php echo $category['name'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url('views/store.php'); ?>"><i class="fas fa-shopping-bag me-1"></i>All Products</a>
                    </li>
                </ul>

                <!-- Search Form -->
                <form class="d-flex me-3" method="GET" action="<?php echo url('views/store.php'); ?>">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                </form>

                <ul class="navbar-nav">
                    <?php if (isLoggedIn()) { ?>
                        <li class="nav-item">
                            <?php if ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'seller') { ?>
                            <a class="nav-link" href="<?php echo url('views/cart.php'); ?>">
                                <i class="fas fa-shopping-cart me-1"></i>
                                <?php if ($cart_count > 0) { ?>
                                    <span class="badge bg-danger"><?php echo $cart_count; ?></span>
                                <?php } ?>
                            </a>
                            <?php } ?>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($_SESSION['first_name']); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION['user_role'] === 'admin') { ?>
                                    <li><a class="dropdown-item" href="<?php echo url('admin/'); ?>"><i class="fas fa-cog me-1"></i>Admin Dashboard</a></li>
                                    <li><a class="dropdown-item" href="<?php echo url('admin/account.php'); ?>"><i class="fas fa-edit me-1"></i>Edit Profile</a></li>
                                <?php } elseif ($_SESSION['user_role'] === 'seller') { ?>
                                    <li><a class="dropdown-item" href="<?php echo url('seller/'); ?>"><i class="fas fa-store me-1"></i>Seller Dashboard</a></li>
                                    <li><a class="dropdown-item" href="<?php echo url('seller/products.php'); ?>"><i class="fas fa-boxes me-1"></i>My Products</a></li>
                                    <li><a class="dropdown-item" href="<?php echo url('seller/orders.php'); ?>"><i class="fas fa-receipt me-1"></i>My Sales</a></li>
                                    <li><a class="dropdown-item" href="<?php echo url('seller/account.php'); ?>"><i class="fas fa-edit me-1"></i>Edit Profile</a></li>
                                <?php } else { ?>
                                    <li><a class="dropdown-item" href="<?php echo url('buyer/'); ?>"><i class="fas fa-user me-1"></i>My Account</a></li>
                                    <li><a class="dropdown-item" href="<?php echo url('buyer/orders.php'); ?>"><i class="fas fa-shopping-bag me-1"></i>My Orders</a></li>
                                    <li><a class="dropdown-item" href="<?php echo url('buyer/account.php'); ?>"><i class="fas fa-edit me-1"></i>Edit Profile</a></li>
                                <?php } ?>
                                
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?php echo url('logout.php'); ?>"><i class="fas fa-sign-out-alt me-1"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo url('login.php'); ?>"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo url('register.php'); ?>"><i class="fas fa-user-plus me-1"></i>Register</a>
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
        <div class="container mt-3 alert-container">
            <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                <i class="fas fa-<?php echo $flash_message['type'] === 'error' ? 'exclamation-triangle' : ($flash_message['type'] === 'success' ? 'check-circle' : 'info-circle'); ?> me-2"></i>
                <?php echo htmlspecialchars($flash_message['text']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php } ?>

</body>

</html>