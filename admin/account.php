<?php
require_once '../includes/header.php';
?>

<!-- Details -->

<section>
    <div class="container">
        <div class="title">
            <h1>Edit Account</h1>
        </div>
        <div class="body">
            <div class="item">
                <div class="display">
                    <h2>Your Name</h2>
                    <p>eg:Name</p>
                    <button>Edit</button>
                </div>
                <div class="form">
                    <form>
                        <h2>Edit Your Name</h2>
                        <input type="text" name="first_name" value="first_name">
                        <input type="text" name="first_name" value="last_name">
                        <button>Cancel</button>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div class="item">
                <div class="display">
                    <h2>Email Address</h2>
                    <p>eg:Email</p>
                    <button>Edit</button>
                </div>
                <div class="form">
                    <form>
                        <h2>Edit Your Email</h2>
                        <input type="text" name="email" value="email">
                        <input type="text" name="password" value="password">
                        <button>Cancel</button>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div class="item">
                <div class="display">
                    <h2>Mobile Number</h2>
                    <p>eg:number</p>
                    <button>Edit</button>
                </div>
                <div class="form">
                    <form>
                        <h2>Edit Mobile Number</h2>
                        <input type="text" name="number" value="number">
                        <button>Cancel</button>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div class="item">
                <div class="display">
                    <h2>Address</h2>
                    <p>eg:Address</p>
                    <button>Edit</button>
                </div>
                <div class="form">
                    <form>
                        <h2>Edit Address</h2>
                        <input type="text" name="address" value="address">
                        <input type="text" name="city" value="city">
                        <input type="text" name="province" value="province">
                        <input type="text" name="zipCode" value="zipCode">
                        <button>Cancel</button>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php
require_once '../includes/footer.php';
?>