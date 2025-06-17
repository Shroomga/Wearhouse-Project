<?php
require_once '../includes/functions.php';
global $db;

$request = isset($_GET['request']) ? $_GET['request'] : '';
if ($request === 'edit') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // Update user details
        $db->query("UPDATE users SET first_name = ?, last_name = ?, username = ?, email = ?, role = ? WHERE id = ?", 
                     [$firstName, $lastName, $username, $email, $role, $_GET['id']]);
        header("Location: users.php");
        exit;
    }
} elseif ($request === 'delete') {
    if (isset($_GET['id'])) {
        // Delete user
        $db->query("DELETE FROM users WHERE id = ?", [$_GET['id']]);
        header("Location: users.php");
        exit;
    }
}

require_once '../includes/header.php';


$user =  $db->fetchOne("SELECT * FROM users WHERE id = ?", [$_GET['id']]);
requireRole("admin");

?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mt-4">Edit User</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="buyer" <?php echo $user['role'] === 'buyer' ? 'selected' : ''; ?>>Buyer</option>
                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update User</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>