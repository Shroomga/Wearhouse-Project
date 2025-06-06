<?php
$page_title = 'Register - Wearhouse';
require_once 'includes/header.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: /');
    exit();
}

$role = sanitizeInput($_GET['role'] ?? 'buyer');
if (!in_array($role, ['buyer', 'seller'])) {
    $role = 'buyer';
}

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userData = [
        'username' => sanitizeInput($_POST['username'] ?? ''),
        'email' => sanitizeInput($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? '',
        'first_name' => sanitizeInput($_POST['first_name'] ?? ''),
        'last_name' => sanitizeInput($_POST['last_name'] ?? ''),
        'phone' => sanitizeInput($_POST['phone'] ?? ''),
        'address' => sanitizeInput($_POST['address'] ?? ''),
        'city' => sanitizeInput($_POST['city'] ?? ''),
        'state' => sanitizeInput($_POST['province'] ?? ''),
        'zip_code' => sanitizeInput($_POST['zip_code'] ?? ''),
        'role' => sanitizeInput($_POST['role'] ?? 'buyer'),
        'terms' => isset($_POST['terms'])
    ];

    // Validation
    $errors = [];

    if (empty($userData['username'])) {
        $errors[] = 'Username is required.';
    } elseif (strlen($userData['username']) < 3) {
        $errors[] = 'Username must be at least 3 characters long.';
    }

    if (empty($userData['email'])) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (empty($userData['password'])) {
        $errors[] = 'Password is required.';
    } elseif (strlen($userData['password']) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }

    if ($userData['password'] !== $userData['confirm_password']) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($userData['first_name'])) {
        $errors[] = 'First name is required.';
    }

    if (empty($userData['last_name'])) {
        $errors[] = 'Last name is required.';
    }

    if (!$userData['terms']) {
        $errors[] = 'You must agree to the terms and conditions.';
    }

    if (empty($errors)) {
        $result = register($userData);
        if ($result['success']) {
            $success_message = $result['message'];
            // Clear form data on success
            $userData = array_fill_keys(array_keys($userData), '');
        } else {
            $error_message = $result['message'];
        }
    } else {
        $error_message = implode('<br>', $errors);
    }
}

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                        <h2 class="card-title">Join Wearhouse</h2>
                        <p class="text-muted">Create your account and start <?php echo $role === 'seller' ? 'selling' : 'shopping'; ?> today</p>
                    </div>

                    <?php if ($success_message){ ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo htmlspecialchars($success_message); ?>
                            <hr>
                            <div class="text-center">
                                <a href="/login.php" class="btn btn-success">
                                    <i class="fas fa-sign-in-alt me-2"></i>Sign In Now
                                </a>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($error_message){ ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo $error_message; ?>
                        </div>
                    <?php } ?>

                    <?php if (!$success_message){ ?>
                        <form method="POST" class="needs-validation" novalidate>

                            <!-- Role Selection -->
                            <div class="mb-4">
                                <label class="form-label">Account Type</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="role" id="buyer" value="buyer" <?php echo $role === 'buyer' ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="buyer">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-shopping-cart text-primary me-2"></i>
                                                    <div>
                                                        <strong>Buyer Account</strong><br>
                                                        <small class="text-muted">Shop for clothing items</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="role" id="seller" value="seller" <?php echo $role === 'seller' ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="seller">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-store text-success me-2"></i>
                                                    <div>
                                                        <strong>Seller Account</strong><br>
                                                        <small class="text-muted">Sell your clothing items</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name *</label>
                                        <input type="text"
                                            class="form-control"
                                            id="first_name"
                                            name="first_name"
                                            value="<?php echo htmlspecialchars($userData['first_name'] ?? ''); ?>"
                                            required>
                                        <div class="invalid-feedback">
                                            Please enter your first name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name *</label>
                                        <input type="text"
                                            class="form-control"
                                            id="last_name"
                                            name="last_name"
                                            value="<?php echo htmlspecialchars($userData['last_name'] ?? ''); ?>"
                                            required>
                                        <div class="invalid-feedback">
                                            Please enter your last name.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username *</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control"
                                        id="username"
                                        name="username"
                                        value="<?php echo htmlspecialchars($userData['username'] ?? ''); ?>"
                                        minlength="3"
                                        required>
                                    <div class="invalid-feedback">
                                        Please choose a username (minimum 3 characters).
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>"
                                        required>
                                    <div class="invalid-feedback">
                                        Please enter a valid email address.
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password"
                                                class="form-control"
                                                id="password"
                                                name="password"
                                                minlength="8"
                                                required>
                                            <div class="invalid-feedback">
                                                Password must be at least 8 characters long.
                                            </div>
                                        </div>
                                        <div class="form-text">
                                            Must contain at least 8 characters with uppercase, lowercase, and numbers.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirm Password *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password"
                                                class="form-control"
                                                id="confirm_password"
                                                name="confirm_password"
                                                required>
                                            <div class="invalid-feedback">
                                                Please confirm your password.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="tel"
                                        class="form-control"
                                        id="phone"
                                        name="phone"
                                        value="<?php echo htmlspecialchars($userData['phone'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control"
                                    id="address"
                                    name="address"
                                    rows="2"><?php echo htmlspecialchars($userData['address'] ?? ''); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text"
                                            class="form-control"
                                            id="city"
                                            name="city"
                                            value="<?php echo htmlspecialchars($userData['city'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text"
                                            class="form-control"
                                            id="state"
                                            name="state"
                                            value="<?php echo htmlspecialchars($userData['state'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="zip_code" class="form-label">ZIP Code</label>
                                        <input type="text"
                                            class="form-control"
                                            id="zip_code"
                                            name="zip_code"
                                            value="<?php echo htmlspecialchars($userData['zip_code'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="terms"
                                        name="terms"
                                        required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="/terms.php" target="_blank">Terms and Conditions</a>
                                        and <a href="/privacy.php" target="_blank">Privacy Policy</a> *
                                    </label>
                                    <div class="invalid-feedback">
                                        You must agree to the terms and conditions.
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </button>
                            </div>
                        </form>
                    <?php } ?>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0">Already have an account?</p>
                        <a href="/login.php" class="btn btn-outline-primary mt-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
    // Password confirmation validation
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;

        if (password !== confirmPassword) {
            this.setCustomValidity('Passwords do not match');
        } else {
            this.setCustomValidity('');
        }
    });

    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

