<?php

require_once '../includes/functions.php';
requireAdminOrSeller();

if (!isset($_GET['id'])) {
    setFlashMessage('No product specified.', 'error');
    header('Location: ' . url('seller/products.php'));
    exit;
}
$product_id = intval($_GET['id']);
$product = getProductById($product_id);
if (!$product || $product['seller_id'] != $_SESSION['user_id']) {
    setFlashMessage('Product not found or not authorized.', 'error');
    header('Location: ' . url('seller/products.php'));
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $category_id = intval($_POST['category_id']);
    $description = sanitizeInput($_POST['description']);
    $price = floatval($_POST['price']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $color = sanitizeInput($_POST['color']);
    $brand = sanitizeInput($_POST['brand']);
    $size = sanitizeInput($_POST['size']);
    $status = in_array($_POST['status'], ['active','inactive','sold']) ? $_POST['status'] : 'active';
    $image_url = $product['image_url'];

    // Handle image upload
    if (!empty($_FILES['image_url']['name'])) {
        $destination_folder = "../uploads/images/products/";
        $upload = uploadImage($_FILES['image_url'], $destination_folder);
        if ($upload['success']) {
            $image_url = $upload['filename'];
            // Optionally delete old image
            if (!empty($product['image_url'])) {
                $old_path =  upload($product['image_url']);
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
        "UPDATE products SET category_id=?, name=?, description=?, price=?, stock_quantity=?, color=?, brand=?, image_url=?, size=?, status=?, updated_at=NOW() WHERE id=? AND seller_id=?",
        [$category_id, $name, $description, $price, $stock_quantity, $color, $brand, $image_url, $size, $status, $product_id, $_SESSION['user_id']],
        'issdisssssii'
    );
    setFlashMessage('Product updated successfully!', 'success');
    var_dump($upload);
    echo "<br><br>";
    echo "Destination folder: " . $destination_folder;
    echo "<br><br>";
    echo "Image url: " . $image_url;
    echo "<br><br>";
    echo "Filename: " . $_FILES['image_url']['name'];
    echo "<br><br>";
    echo "Database image url: " . $product['image_url'];
    exit;
}
require_once '../includes/header.php';
$categories = getCategories('all');
$this_category = getCategoryById($product['category_id']);
?>
<div class="container mt-4">
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="<?php echo $this_category['id']; ?>" <?php if ($this_category['id'] == $product['category_id']) echo 'selected'; ?>><?php echo htmlspecialchars($this_category['name']); ?></option>
                <?php foreach ($categories as $category) { ?>
                    <?php if ($category['id'] != $this_category['id']) { ?>
                        <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $product['category_id']) echo 'selected'; ?>><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Stock Quantity</label>
            <input type="number" name="stock_quantity" class="form-control" value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Color</label>
            <input type="text" name="color" class="form-control" value="<?php echo htmlspecialchars($product['color']); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Brand</label>
            <input type="text" name="brand" class="form-control" value="<?php echo htmlspecialchars($product['brand']); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Size</label>
            <input type="text" name="size" class="form-control" value="<?php echo htmlspecialchars($product['size']); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active" <?php if ($product['status'] == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if ($product['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                <option value="sold" <?php if ($product['status'] == 'sold') echo 'selected'; ?>>Sold</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Product Image</label>
            <?php if (!empty($product['image_url'])) { ?>
                <div class="mb-2">
                    <img src="<?php echo '/uploads/' . $product['image_url']; ?>" alt="Current Image" style="max-width: 120px; max-height: 120px;">
                </div>
            <?php } ?>
            <input type="file" name="image_url" class="form-control" accept="image/*">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="<?php echo url('seller/products.php'); ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>