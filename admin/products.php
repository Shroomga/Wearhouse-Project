<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
global $db;
$products = $db->fetchAll("SELECT * FROM products ORDER BY name");
?>

<div class="admin-container">


  <?php foreach ($products as $product) { ?>
    <div class="admin-item">
        <form action="" method="POST">
            <div class="admin-item-body">
                <h5 class="card-title"><?php echo $product['name']?></h5>
                <p class="card-text"><?php echo $product['description']?></p>
                <p class="card-text"><?php echo formatPrice($product['price'])?></p>
                <div class="admin-buttons">
                    <a href="./product.php?request=edit" class="btn btn-success btn-lg">Edit</a>
                    <a href="./product.php?request=delete" class="btn btn-danger btn-lg">Delete</a>
                </div>
            </div>
        </form>

    </div>
    <?php }?>

    <?php
    require_once '../includes/footer.php';
    ?>