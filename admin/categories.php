<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
global $db;
$categories = $db->fetchAll("SELECT * FROM categories ORDER BY name");
?>

<div class="admin-container">


  <?php foreach ($categories as $category) { ?>
    <div class="admin-item">
        <form action="" method="POST">
            <div class="admin-item-body">
                <h5 class="card-title"><?php echo $category['name']?></h5>
                <p class="card-text"><?php echo $category['description']?></p>
                <div class="admin-buttons">
                    <a href="./category.php?request=edit" class="btn btn-success btn-lg">Edit</a>
                    <a href="./category.php?request=delete" class="btn btn-danger btn-lg">Delete</a>
                </div>
            </div>
        </form>

    </div>
    <?php }?>

    <?php
    require_once '../includes/footer.php';
    ?>