<?php
require_once '../includes/functions.php';
requireRole("admin");
global $db;
if (!isset($_GET['id'])) {
    setFlashMessage('No product specified.', 'error');
    header('Location: ' . url('seller/products.php'));
    exit;
}
$product_id = intval($_GET['id']);
$product = getProductById($product_id);

$request = isset($_GET['request']) ? $_GET['request'] : '';
if ($request === 'edit') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = sanitizeInput($_POST['name']);
        $category_id = intval($_POST['category_id']);
        $description = sanitizeInput($_POST['description']);
        $price = floatval($_POST['price']);
        $color = sanitizeInput($_POST['color']);
        $size = sanitizeInput($_POST['size']);
        $image_url = $product['image_url'];
    
        // Handle image upload
        if (!empty($_FILES['image_url']['name'])) {
            $destination_folder = "../uploads/images/products/";
            $upload = uploadImage($_FILES['image_url'], $destination_folder);
            if ($upload['success']) {
                $image_url = $upload['filename'];
                // Optionally delete old image
                if (!empty($product['image_url'])) {
                    $old_path =  upload("images/products/" . $product['image_url']);
                    if (file_exists($old_path)) {
                        @unlink($old_path);
                    }
                }
            } else {
                setFlashMessage($upload['message'], 'error');
            }
        }
    
        global $db;
        $db->query(
            "UPDATE products SET category_id=?, name=?, description=?, price=?, color=?, image_url=?, size=?, updated_at=NOW() WHERE id=?",
            [$category_id, $name, $description, $price, $color, $image_url, $size, $_GET['id']],
            'issdsssi'
        );
        setFlashMessage('Product updated successfully!', 'success');
        header('Location: ' . url('admin/products.php'));
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
$categories = getCategories('all');
$this_category = getCategoryById($product['category_id']);
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mt-4">Edit Product</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id">
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category['id']; ?>" <?php echo $this_category['id'] == $category['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php } ?>
                    </select>
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
                <div class="form-group mt-3">
                    <label class="form-label">Image</label>
                    <input type="file" class="form-control-file" accept="image/*" name="image_url">
                    <?php if ($product['image_url']) { ?>
                        <img src="<?php echo $product['image_url'] ? upload("images/products/" . $product['image_url']) : asset('images/placeholder-product.svg'); ?>" alt="Product Image" class="img-thumbnail mt-2" style="max-width: 200px;">
                    <?php } else { ?>
                        <p>No image uploaded.</p>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update Product</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>