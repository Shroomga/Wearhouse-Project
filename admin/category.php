<?php
require_once '../includes/functions.php';
global $db;

$request = isset($_GET['request']) ? $_GET['request'] : '';
if ($request === 'edit') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];

        // Update category details
        $db->query("UPDATE categories SET name = ?, description = ? WHERE id = ?", 
                     [$name, $description, $_GET['id']]);
        header("Location: categories.php");
        exit;
    }
} elseif ($request === 'delete') {
    if (isset($_GET['id'])) {
        // Delete category
        $db->query("DELETE FROM categories WHERE id = ?", [$_GET['id']]);
        header("Location: categories.php");
        exit;
    }
}

require_once '../includes/header.php';


$category =  $db->fetchOne("SELECT * FROM categories WHERE id = ?", [$_GET['id']]);
requireRole("admin");

?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mt-4">Edit Category</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($category['description']); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update Category</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>