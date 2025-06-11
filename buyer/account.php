<?php
require_once '../includes/functions.php';
require_once '../includes/header.php';
global $db;
requireLogin();
$id = $_SESSION['user_id'];
$user = $db->fetchOne("SELECT * FROM users WHERE id = ?", [$id], 'i');

foreach ($user as $key => $value) {
    if ($key != "id") {
        if (empty($value)) {
            $user[$key] = $key;
        }
    }
}
?>

<!-- Details -->

<section>
    <div class="container">
        <div class="title">
            <h1>Edit Account</h1>
        </div>
        <div class="details-body">
            <div class="item" id="fullname">
                <div class="account-display">
                    <h2>Your Name</h2>
                    <p><?php echo "{$user['first_name']} {$user['last_name']}" ?></p>
                    <button>Edit</button>
                </div>
                <div class="account-form hidden">
                    <form action="" method="post" class="edit-form">
                        <div>
                            <h2>Edit Your Name</h2>
                            <input type="text" name="first_name" value=<?php echo $user['first_name'] ?>>
                            <input type="text" name="first_name" value=<?php echo $user['last_name'] ?>>
                        </div>
                        <div>
                            <button type="button">Cancel</button>
                            <button type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="item" id="email">
                <div class="account-display">
                    <h2>Email Address</h2>
                    <p><?php echo $user['email'] ?></p>
                    <button>Edit</button>
                </div>
                <div class="account-form hidden">
                    <form action="" method="post" class="edit-form">
                        <div>
                            <h2>Edit Your Email</h2>
                            <input type="text" name="email" value=<?php echo $user['email'] ?>>
                            <input type="password" name="password" value="password">
                        </div>
                        <div>
                            <button type="button">Cancel</button>
                            <button type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="item" id="phone-number">
                <div class="account-display">
                    <h2>Mobile Number</h2>
                    <p><?php echo $user['phone'] ?></p>
                    <button>Edit</button>
                </div>
                <div class="account-form hidden">
                    <form action="" method="post" class="edit-form">
                        <div>
                            <h2>Edit Mobile Number</h2>
                            <input type="text" name="number" value=<?php echo $user['phone'] ?>>
                            <input type="password" name="password" value="password">
                        </div>
                        <div>
                            <button type="button">Cancel</button>
                            <button type="submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
            <div class="item" id="address">
                <div class="account-display">
                    <h2>Address</h2>
                    <p><?php echo "{$user['address']}, {$user['city']}, {$user['province']}, {$user['zip_code']}" ?? "Mobile Number" ?></p>
                    <button>Edit</button>
                </div>
                <div class="account-form hidden">
                    <form action="" method="post" class="edit-form">
                        <div>
                            <h2>Edit Address</h2>
                            <input type="text" name="address" value=<?php echo $user['address'] ?>>
                            <input type="text" name="city" value=<?php echo $user['city'] ?>>
                            <input type="text" name="province" value=<?php echo $user['province'] ?>>
                            <input type="text" name="zipCode" value=<?php echo $user['zip_code'] ?>>
                        </div>
                        <div>
                            <button type="button">Cancel</button>
                            <button type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php
require_once '../includes/footer.php';
?>