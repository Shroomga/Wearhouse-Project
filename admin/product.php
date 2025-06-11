<?php
require_once '../includes/functions.php';
global $db;

$request = isset($_GET['request']) ? $_GET['request'] : '';
if ($request === 'edit') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $color = $_POST['color'];
        $size = $_POST['size'];
        var_dump($_FILES);
        $image = uploadImage($_FILES['image'], 'products');
        $imageUrl = $image ? $image['filename'] : null;
        $price = $_POST['price'];

        // Update product details
        $db->query(
            "UPDATE products SET name = ?, description = ?, price = ?, color = ?, size = ?, image = ? WHERE id = ?",
            [$name, $description, $price, $color, $size, $imageUrl, $_GET['id']]
        );
        header("Location: products.php");
        exit;
    }
} elseif ($request === 'delete') {
    if (isset($_GET['id'])) {
        // Delete product
        $db->query("DELETE FROM products WHERE id = ?", [$_GET['id']]);
        header("Location: products.php");
        exit;
    }
}

require_once '../includes/header.php';


$product =  $db->fetchOne("SELECT * FROM products WHERE id = ?", [$_GET['id']]);
requireRole("admin");

?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mt-4">Edit Product</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" class="form-control" id="color" name="color" value="<?php echo htmlspecialchars($product['color']); ?>">
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text" class="form-control" id="size" name="size" value="<?php echo htmlspecialchars($product['size']); ?>">
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    <?php if ($product['image_url']) { ?>
                        <img src="/uploads/<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" class="img-thumbnail mt-2" style="max-width: 200px;">
                    <?php } else { ?>
                        <p>No image uploaded.</p>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>