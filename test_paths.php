<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class PathTester {
    private $baseDir;
    private $results = [];
    private $failedPaths = [];

    public function __construct($baseDir) {
        $this->baseDir = $baseDir;
    }

    public function testPath($path, $type = 'file') {
        $fullPath = $this->baseDir . '/' . $path;
        $exists = file_exists($fullPath);
        $this->results[] = [
            'path' => $path,
            'type' => $type,
            'exists' => $exists,
            'full_path' => $fullPath
        ];
        if (!$exists) {
            $this->failedPaths[] = $path;
        }
        return $exists;
    }

    public function testImagePath($path) {
        return $this->testPath($path, 'image');
    }

    public function testIncludePath($path) {
        return $this->testPath($path, 'include');
    }

    public function testCSSPath($path) {
        return $this->testPath($path, 'css');
    }

    public function getResults() {
        return $this->results;
    }

    public function getFailedPaths() {
        return $this->failedPaths;
    }
}

// Initialize tester
$tester = new PathTester(__DIR__);

// Test CSS files
$tester->testCSSPath('assets/css/styles.css');

// Test image paths
$tester->testImagePath('assets/images/hero-fashion.svg');
$tester->testImagePath('assets/images/placeholder-product.svg');
$tester->testImagePath('assets/images/home background.jpg');

// Test include files
$tester->testIncludePath('includes/header.php');
$tester->testIncludePath('includes/footer.php');
$tester->testIncludePath('includes/functions.php');
$tester->testIncludePath('config/database.php');

// Test upload directories
$tester->testPath('uploads');

// Test view files
$tester->testPath('views/store.php');
$tester->testPath('views/cart.php');
$tester->testPath('views/check-out.php');
$tester->testPath('views/account.html');

// Test main PHP files
$tester->testPath('index.php');
$tester->testPath('product.php');
$tester->testPath('login.php');
$tester->testPath('register.php');
$tester->testPath('logout.php');
$tester->testPath('unauthorized.php');

// Test seller files
$tester->testPath('seller/products.php');
$tester->testPath('seller/index.php');
$tester->testPath('seller/account.php');

// Test buyer files
$tester->testPath('buyer/account.php');

// Test admin files
$tester->testPath('admin/users.php');

// Display results
echo "<h1>Path Testing Results</h1>";

// Display failed paths
$failedPaths = $tester->getFailedPaths();
if (!empty($failedPaths)) {
    echo "<h2>Failed Paths:</h2>";
    echo "<ul style='color: red;'>";
    foreach ($failedPaths as $path) {
        echo "<li>$path</li>";
    }
    echo "</ul>";
} else {
    echo "<h2 style='color: green;'>All paths are valid!</h2>";
}

// Display all results
echo "<h2>Detailed Results:</h2>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Path</th><th>Type</th><th>Status</th><th>Full Path</th></tr>";

foreach ($tester->getResults() as $result) {
    $status = $result['exists'] ? 
        "<span style='color: green;'>✓</span>" : 
        "<span style='color: red;'>✗</span>";
    echo "<tr>";
    echo "<td>{$result['path']}</td>";
    echo "<td>{$result['type']}</td>";
    echo "<td>$status</td>";
    echo "<td>{$result['full_path']}</td>";
    echo "</tr>";
}

echo "</table>";

// Test URL paths
echo "<h2>URL Path Testing:</h2>";
echo "<p>Testing root-relative URL paths...</p>";

$urlPaths = [
    // Asset paths
    '/assets/css/styles.css',
    '/assets/images/hero-fashion.svg',
    '/assets/images/placeholder-product.svg',
    '/assets/images/home background.jpg',
    
    // Upload paths
    '/uploads/',
    '/uploads/products/',
    
    // Test with actual product images if they exist
    '/uploads/sample-product.jpg',
    '/uploads/sample-product.png'
];

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>URL Path</th><th>Status</th><th>Full URL</th></tr>";

foreach ($urlPaths as $path) {
    $fullUrl = 'http://' . $_SERVER['HTTP_HOST'] . $path;
    $headers = @get_headers($fullUrl);
    $status = $headers && strpos($headers[0], '200') !== false ? 
        "<span style='color: green;'>✓</span>" : 
        "<span style='color: red;'>✗</span>";
    
    echo "<tr>";
    echo "<td>$path</td>";
    echo "<td>$status</td>";
    echo "<td>$fullUrl</td>";
    echo "</tr>";
}

echo "</table>";

// Test directory structure
echo "<h2>Directory Structure Test:</h2>";
echo "<p>Verifying required directories exist and are accessible...</p>";

$requiredDirs = [
    'assets',
    'assets/css',
    'assets/images',
    'uploads',
    'uploads/products'
];

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Directory</th><th>Status</th><th>Full Path</th></tr>";

foreach ($requiredDirs as $dir) {
    $fullPath = __DIR__ . '/' . $dir;
    $exists = is_dir($fullPath);
    $writable = is_writable($fullPath);
    $status = $exists ? 
        ($writable ? 
            "<span style='color: green;'>✓ (Writable)</span>" : 
            "<span style='color: orange;'>✓ (Not Writable)</span>") : 
        "<span style='color: red;'>✗</span>";
    
    echo "<tr>";
    echo "<td>$dir</td>";
    echo "<td>$status</td>";
    echo "<td>$fullPath</td>";
    echo "</tr>";
}

echo "</table>";

// Test file permissions
echo "<h2>File Permission Test:</h2>";
echo "<p>Checking critical file permissions...</p>";

$criticalFiles = [
    'assets/css/styles.css',
    'includes/header.php',
    'includes/functions.php',
    'config/database.php'
];

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>File</th><th>Status</th><th>Permissions</th></tr>";

foreach ($criticalFiles as $file) {
    $fullPath = __DIR__ . '/' . $file;
    $exists = file_exists($fullPath);
    $readable = is_readable($fullPath);
    $status = $exists ? 
        ($readable ? 
            "<span style='color: green;'>✓ (Readable)</span>" : 
            "<span style='color: orange;'>✓ (Not Readable)</span>") : 
        "<span style='color: red;'>✗</span>";
    
    $perms = $exists ? substr(sprintf('%o', fileperms($fullPath)), -4) : 'N/A';
    
    echo "<tr>";
    echo "<td>$file</td>";
    echo "<td>$status</td>";
    echo "<td>$perms</td>";
    echo "</tr>";
}

echo "</table>";
?> 