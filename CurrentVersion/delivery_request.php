<?php
session_start();
require_once "pdo.php";

// echo '<pre>';
// echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "\n";
// echo "POST Data:\n";
// print_r($_POST);
// echo '</pre>';

if (isset($_POST['cart_data'])) {
    $cart_data_json = $_POST['cart_data'];
    $cart = json_decode($cart_data_json, true);
    if ($cart === null && json_last_error() !== JSON_ERROR_NONE) {
        echo "Error: Invalid JSON in cart_data.";
        exit;
    }
} else {
    echo "Error: Cart data not received.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Local Finder - Delivery Request</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        form {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        #sub1{
            width:200px;
        }
        .cart-item {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
        }

        .cart-item .item-details {
            display: inline-block;
        }
    </style>
</head>

<body>
    <header>
        <div id="logo_1"></div>
        <div>
            <nav>
                <div><a href="about.php"><i class="fas fa-info-circle"></i> About Us</a></div>
                <div><a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a></div>
            </nav>
        </div>
    </header>
    <h1>Delivery Request</h1>

    <h2>Cart Items:</h2>
    <?php if (empty($cart)) : ?>
        <p>Your cart is empty.</p>
    <?php else : ?>
        <?php foreach ($cart as $item) : ?>
            <div class="cart-item">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <div class="item-details">
                    <h4><?= htmlspecialchars($item['name']) ?></h4>
                    <p>Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                    <p>Price: $<?= htmlspecialchars(number_format($item['price'] * $item['quantity'], 2)) ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <form action="request_delivery.php" method="POST">
            <!-- Include cart data as a hidden input -->
            <input type="hidden" name="cart_data" value="<?= htmlspecialchars($cart_data_json) ?>">

            <label for="delivery_address"><i class="fas fa-map-marker-alt"></i> Delivery Address:</label>
            <textarea id="delivery_address" name="delivery_address" required></textarea>

            <label for="delivery_date"><i class="fas fa-calendar-alt"></i> Preferred Delivery Date:</label>
            <input type="date" id="delivery_date" name="delivery_date" required>

            <label for="delivery_timing"><i class="fas fa-clock"></i> Preferred Delivery Timing:</label>
            <select id="delivery_timing" name="delivery_timing" required>
                <option value="">Select Timing</option>
                <option value="9:00">9:00 AM - 12:00 PM</option>
                <option value="12:00">12:00 PM - 3:00 PM</option>
                <option value="15:00">3:00 PM - 6:00 PM</option>
                <option value="18:00">6:00 PM - 9:00 PM</option>
            </select>

            <label for="special_instructions"><i class="fas fa-sticky-note"></i> Special Instructions:</label>
            <textarea id="special_instructions" name="special_instructions"></textarea>

            <center><input id="sub1" type="submit" value="Request Delivery"></center>
        </form>
    <?php endif; ?>

    <footer>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <div class="copyright">
            &copy; 2025 LocalFinder. All rights reserved.
        </div>
    </footer>
</body>
</html>
