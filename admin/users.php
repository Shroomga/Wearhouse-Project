<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
global $db;
$users = $db->fetchAll("SELECT * FROM users WHERE role !='admin' ORDER BY first_name");
?>

<div class="admin-container">


  <?php foreach ($users as $user) { ?>
    <div class="admin-item">
        <form action="" method="POST">
            <div class="admin-item-body">
                <h5 class="card-title"><?php echo $user['first_name'] . " " . $user['last_name']?></h5>
                <p class="card-text"><?php echo $user['username']?></p>
                <p class="card-text"><?php echo $user['role']?></p>
                <div class="admin-buttons">
                    <a href="./user.php?request=edit" class="btn btn-success btn-lg">Edit</a>
                    <a href="./user.php?request=delete" class="btn btn-danger btn-lg">Delete</a>
                </div>
            </div>
        </form>

    </div>
    <?php }?>

    <?php
    require_once '../includes/footer.php';
    ?>