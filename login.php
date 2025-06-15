<?php
$page_title = 'Login - Wearhouse'; //will be used in the include
require_once 'includes/functions.php';
require_once 'config/config.php';
if (isLoggedIn()) {
    $redirect = match ($_SESSION['user_role']) {
        'admin' => url('admin/index.php'),
        'seller' => url('seller/index.php'),
        default => url('index.php')
    };
    header("Location: $redirect");
    exit();
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember_me = isset($_POST['remember_me']);

    if (empty($username) || empty($password)) {
        $error_message = 'Please enter both username/email and password.';
    } else {
        if (login($username, $password)) {
            // Set remember me cookie if selected
            if ($remember_me) {
                setcookie('remember_user', $username, time() + (86400 * 30), '/'); // 30 days
            }

            // Redirect based on user role
            $redirect = match ($_SESSION['user_role']) {
                'admin' => url('admin/index.php'),
                'seller' => url('seller/index.php'),
                default => url('index.php')
            };

            showMessage('Welcome back, ' . $_SESSION['first_name'] . '!', 'success');
            header("Location: $redirect");
            exit();
        } else {
            $error_message = 'Invalid username/email or password.';
        }
    }
}
require_once 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-tshirt fa-3x text-primary mb-3"></i>
                        <h2 class="card-title">Welcome Back</h2>
                        <p class="text-muted">Sign in to your Wearhouse account</p>
                    </div>

                    <?php if ($error_message): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Username or Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="username" 
                                       name="username" 
                                       value="<?php echo htmlspecialchars($_POST['username'] ?? $_COOKIE['remember_user'] ?? ''); ?>"
                                       placeholder="Enter your username or email"
                                       required>
                                <div class="invalid-feedback">
                                    Please enter your username or email.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter your password"
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div class="invalid-feedback">
                                    Please enter your password.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="remember_me" 
                                       name="remember_me"
                                       <?php echo isset($_COOKIE['remember_user']) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="remember_me">
                                    Remember me for 30 days
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="<?php echo url('forgot-password.php'); ?>" class="text-decoration-none">
                            <i class="fas fa-key me-1"></i>Forgot your password?
                        </a>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0">Don't have an account?</p>
                        <div class="d-grid gap-2 mt-3">
                            <a href="<?php echo url('register.php'); ?>" class="btn btn-outline-primary">
                                <i class="fas fa-user-plus me-2"></i>Create Account as Buyer
                            </a>
                            <a href="<?php echo url('register.php?role=seller'); ?>" class="btn btn-outline-success">
                                <i class="fas fa-store me-2"></i>Join as Seller
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Demo Accounts Info -->
            <div class="card mt-4 bg-light">
                <div class="card-body">
                    <h6 class="card-title text-center">
                        <i class="fas fa-info-circle me-2 text-info"></i>Demo Accounts
                    </h6>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <strong>Admin</strong><br>
                            <small>admin@wearhouse.com</small><br>
                            <small>password</small>
                        </div>
                        <div class="col-md-4">
                            <strong>Seller</strong><br>
                            <small>jane@example.com</small><br>
                            <small>fashionjane</small>
                        </div>
                        <div class="col-md-4">
                            <strong>Buyer</strong><br>
                            <small>john@example.com</small><br>
                            <small>password</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once 'includes/footer.php'; ?>
