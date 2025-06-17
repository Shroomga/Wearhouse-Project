<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
requireRole("admin");
global $db;
$categories = $db->fetchAll("SELECT * FROM categories ORDER BY id");
?>

<div class="admin-container">

    <?php if (empty($categories)) { ?>
        <p>No categories found.</p>
    <?php } else { ?>
        <?php foreach ($categories as $category) { ?>
            <div class="admin-item">
                <form action="" method="POST">
                    <div class="admin-item-body">
                        <h5 class="card-title"><?php echo $category['name'] ?></h5>
                        <p class="card-text"><?php echo $category['description'] ?></p>
                        <?php if (!empty($category['parent_id'])) { ?>
                            <p class="card-text">Parent Category: <?php echo $db->fetchOne("SELECT name FROM categories WHERE id = ?", [$category['parent_id']])['name'] ?></p>
                        <?php } ?>
                        <div class="admin-buttons">
                            <a href="<?php echo url("admin/category.php?request=edit&id=" . urlencode($category['id'])); ?>" class="btn btn-success btn-lg">Edit</a>
                            <a href="<?php echo url("admin/category.php?request=delete&id=" . urlencode($category['id'])); ?>" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<?php
require_once '../includes/footer.php';
?>