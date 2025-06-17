<?php

require_once '../includes/functions.php';
requireAdminOrSeller();

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
    $seller_id = $_SESSION['user_id'];
    $image_url = null;

    // Handle image upload
    if (!empty($_FILES['image_url']['name'])) {
        $upload = uploadImage($_FILES['image_url'], 'uploads/images/products/');
        if ($upload['success']) {
            $image_url = 'images/products/' . $upload['filename'];
        } else {
            setFlashMessage($upload['message'], 'error');
        }
    }

    global $db;
    $db->query(
        "INSERT INTO products (seller_id, category_id, name, description, price, stock_quantity, color, brand, image_url, size, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())",
        [$seller_id, $category_id, $name, $description, $price, $stock_quantity, $color, $brand, $image_url, $size, $status],
        'iissdisssss'
    );
    setFlashMessage('Product added successfully!', 'success');
    header('Location: ' . url('seller/products.php'));
    exit;
}

require_once '../includes/header.php';
$categories = getCategories('all');
?>
<div class="container mt-4">
    <h2>Add New Product</h2>
    <form method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat) { ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Stock Quantity</label>
            <input type="number" name="stock_quantity" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Color</label>
            <input type="text" name="color" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Brand</label>
            <input type="text" name="brand" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Size</label>
            <input type="text" name="size" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="sold">Sold</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Product Image</label>
            <input type="file" name="image_url" class="form-control" accept="image/*">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Add Product</button>
            <a href="<?php echo url('seller/products.php'); ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>