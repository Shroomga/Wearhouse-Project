<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
requireRole("admin");
global $db;
$users = $db->fetchAll("SELECT * FROM users WHERE role !='admin' ORDER BY first_name");
?>

<div class="admin-container">


    <?php if (empty($users)) { ?>
        <p>No users found.</p>
    <?php } else { ?>
        <?php foreach ($users as $user) { ?>
            <div class="admin-item">
                <div class="admin-item-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($user['first_name'] . " " . $user['last_name']); ?></h5>
                    <p class="card-text">Username: <?php echo htmlspecialchars($user['username']); ?></p>
                    <p class="card-text">Role: <?php echo htmlspecialchars($user['role']); ?></p>
                    <div class="admin-buttons">
                        <a href="./user.php?request=edit&id=<?php echo urlencode($user['id']); ?>" class="btn btn-success btn-lg">Edit</a>
                        <a href="./user.php?request=delete&id=<?php echo urlencode($user['id']); ?>" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<?php
require_once '../includes/footer.php';
?>