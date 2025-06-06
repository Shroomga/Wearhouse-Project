<?php
require_once '../includes/header.php';
?>

<!-- Data section -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <h2># of Users</h2>
                <p>#</p>
            </div>
            <div class="col-3">
                <h2># of Sellers</h2>
                <p>#</p>
            </div>
            <div class="col-3">
                <h2># of Products</h2>
                <p>#</p>
            </div>
            <div class="col-3">
                <h2># of Orders</h2>
                <p>#</p>
            </div>
        </div>
    </div>
</section>

<!-- Sidebar 
<section>

</section> -->

<!-- Selection Pane -->
<section>
    <div class="container text-center">
        <div class="row">
            <div class="col-6">
                <a href="./users.php" class="btn btn-primary btn-lg">Modify Users</a>
            </div>
            <div class="col-6">
                <a href="./products.php" class="btn btn-primary btn-lg">Modify Products</a>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <a href="./categories.php" class="btn btn-primary btn-lg">Modify Categories</a>
            </div>
            <div class="col-6">
                <a href="./orders.php" class="btn btn-primary btn-lg">View Orders</a>
            </div>
        </div>
    </div>
</section>

<?php
require_once '../includes/footer.php';
?>