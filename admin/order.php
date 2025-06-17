<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
requireRole("admin");
$orders = getOrders();
?>

<!-- We wont actually use this page -->
 
<?php
require_once '../includes/footer.php';
?>