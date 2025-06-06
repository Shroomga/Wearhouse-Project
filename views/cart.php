<?php
require_once '../includes/header.php';
?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1>Cart:</h1>
        </div>
    </div>
    <div class="row cart">
        <div class="col">
            <div class="header">

            </div>
            <div class="body">
                <ul class="body-items">
                    <li>
                        <img src="/example.png">
                        <p>name</p>
                        <p>price</p>
                        <input type="number">
                        <p>Total</p>
                    </li>
                </ul>
            </div>
            <div>
        </div>
    </div>
    <div class="col totals">
            <form>
                <h2>Estimate Total</h2>
                <input name="address" value="address" type="text">
                <input name="zip_code" value="Zip Code" type="text">
                <button type="submit">Calculate Total</button>
                <p>Quantity: x amount</p>
            <p>Commission: x amount</p>
            <p>Subtotal: x amount</p>
            <p>Total Price: x amount /w tax</p>

            <p>Total Price: x amount</p>
            
            <input type="checkbox" name="terms">
            <button type="submit">Checkout</button>
            </form>

            
        </div>
</div>



<?php
require_once '../includes/footer.php';
?>