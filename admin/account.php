<?php
require_once '../includes/functions.php';
global $db;
requireLogin();

$id = $_SESSION['user_id'];
$user = $db->fetchOne("SELECT * FROM users WHERE id = ?", [$id], 'i');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = false;
    $error = '';
    
    // Verify password for all forms
    $password = $_POST['password'] ?? '';
    if (!password_verify($password, $user['password'])) {
        $error = 'Invalid password';
    } else {
        // Handle name update
        if (isset($_POST['update_name'])) {
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            
            if (empty($first_name) || empty($last_name)) {
                $error = 'First name and last name are required';
            } else {
                $update = $db->query(
                    "UPDATE users SET first_name = ?, last_name = ? WHERE id = ?",
                    [$first_name, $last_name, $id],
                    'ssi'
                );
                $success = "Profile updated successfully!";
            }
        }
        
        // Handle email update
        if (isset($_POST['update_email'])) {
            $email = trim($_POST['email']);
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Valid email is required';
            } else {
                $update = $db->query(
                    "UPDATE users SET email = ? WHERE id = ?",
                    [$email, $id],
                    'si'
                );
                $success = "Profile updated successfully!";
            }
        }
        
        // Handle phone update
        if (isset($_POST['update_phone'])) {
            $phone = trim($_POST['number']);
            
            if (empty($phone)) {
                $error = 'Phone number is required';
            } else {    
                $update = $db->query(
                    "UPDATE users SET phone = ? WHERE id = ?",
                    [$phone, $id],
                    'si'
                );
                $success = "Profile updated successfully!";
            }
        }
        
        // Handle address update
        if (isset($_POST['update_address'])) {
            $address = trim($_POST['address']);
            $city = trim($_POST['city']);
            $province = trim($_POST['province']);
            $zip_code = trim($_POST['zipCode']);
            
            if (empty($address) || empty($city) || empty($province) || empty($zip_code)) {
                $error = 'All address fields are required';
            } else {
                $update = $db->query(
                    "UPDATE users SET address = ?, city = ?, province = ?, zip_code = ? WHERE id = ?",
                    [$address, $city, $province, $zip_code, $id],
                    'ssssi'
                );
                $success = "Profile updated successfully!";
            }
        }
    }
    
    // Refresh user data after update
    if ($error) {
        setFlashMessage($error, 'error');
    }
    if ($success) {
        setFlashMessage($success, 'success');
    }
    header('Location: ' . url('admin/account.php'));
    exit;
}


foreach ($user as $key => $value) {
    if ($key != "id") {
        if (empty($value)) {
            $user[$key] = $key;
        }
    }
}
require_once '../includes/header.php';
?>

<!-- Details -->

<section>
    <div class="container">
        <div class="title py-3">
            <h1>Edit Account</h1>
        </div>
        <div class="details-body">
            <div class="item" id="fullname">
                <div class="account-display">
                    <h2>Your Name</h2>
                    <p><?php echo "{$user['first_name']} {$user['last_name']}" ?></p>
                    <button class="edit-button">Edit</button>
                </div>
                <div class="account-form hidden">
                    <form action="" method="post" class="edit-form">
                        <div>
                            <h2>Edit Your Name</h2>
                            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']) ?>" required>
                            <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']) ?>" required>
                            <input type="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div>
                            <button type="button" class="cancel-button">Cancel</button>
                            <button type="submit" name="update_name" class="submit-button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="item" id="email">
                <div class="account-display">
                    <h2>Email Address</h2>
                    <p><?php echo htmlspecialchars($user['email']) ?></p>
                    <button class="edit-button">Edit</button>
                </div>
                <div class="account-form hidden">
                    <form action="" method="post" class="edit-form">
                        <div>
                            <h2>Edit Your Email</h2>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']) ?>" required>
                            <input type="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div>
                            <button type="button" class="cancel-button">Cancel</button>
                            <button type="submit" name="update_email" class="submit-button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="item" id="phone-number">
                <div class="account-display">
                    <h2>Mobile Number</h2>
                    <p><?php echo htmlspecialchars($user['phone']) ?></p>
                    <button class="edit-button">Edit</button>
                </div>
                <div class="account-form hidden">
                    <form action="" method="post" class="edit-form">
                        <div>
                            <h2>Edit Mobile Number</h2>
                            <input type="tel" name="number" value="<?php echo htmlspecialchars($user['phone']) ?>" required>
                            <input type="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div>
                            <button type="button" class="cancel-button">Cancel</button>
                            <button type="submit" name="update_phone" class="submit-button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="item" id="address">
                <div class="account-display">
                    <h2>Address</h2>
                    <p><?php echo htmlspecialchars("{$user['address']}, {$user['city']}, {$user['province']}, {$user['zip_code']}") ?></p>
                    <button class="edit-button">Edit</button>
                </div>
                <div class="account-form hidden">
                    <form action="" method="post" class="edit-form">
                        <div>
                            <h2>Edit Address</h2>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']) ?>" placeholder="Street Address" required>
                            <input type="text" name="city" value="<?php echo htmlspecialchars($user['city']) ?>" placeholder="City" required>
                            <input type="text" name="province" value="<?php echo htmlspecialchars($user['province']) ?>" placeholder="Province" required>
                            <input type="text" name="zipCode" value="<?php echo htmlspecialchars($user['zip_code']) ?>" placeholder="ZIP Code" required>
                            <input type="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div>
                            <button type="button" class="cancel-button">Cancel</button>
                            <button type="submit" name="update_address" class="submit-button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once '../includes/footer.php';
?>