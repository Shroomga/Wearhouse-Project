<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
requireRole("admin");
$orders = getOrders();
?>


<?php
require_once '../includes/footer.php';
?>