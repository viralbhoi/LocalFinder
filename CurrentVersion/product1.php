<?php
session_start();
require_once "pdo.php";

$loggedIn = isset($_SESSION['Name']);
$cart = $_SESSION['cartData'] ?? [];

if (!isset($_GET['pid'])) {
    die("Product ID not provided.");
}

try {
    $stmt = $pdo->prepare("SELECT * FROM product WHERE Pid = ?");
    $stmt->execute([$_GET['pid']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        die("Product not found.");
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Database error.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($product['Pname']) ?> | LocalFinder</title>
    <link rel="stylesheet" href="styles/style.css"/>
    <link rel="stylesheet" href="styles/style1.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        #user-profile-container {
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
        }
        #user-avatar {
            background-color: #eee;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 1.2em;
            text-align: center;
            line-height: 30px;
            margin-right: 5px;
            font-weight: bold;
            color: #333;
        }
        #dropdown-content {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 35px;
            right: 0;
            background: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            border-radius: 6px;
            z-index: 999;
        }
        #cart-content {
            position: fixed;
            top: 0;
            right: -100%;
            width: 350px;
            height: 100%;
            background-color: #f9f9f9;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
            padding: 20px;
            overflow-y: auto;
            transition: right 0.3s ease-in-out;
            z-index: 1000;
        }
        .cart-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<header>
    <div id="logo_1" onclick="window.location.href='index.php'"></div>
    <nav>
        <div><a href="about.php"><i class="fas fa-info-circle"></i> About</a></div>
        <div><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></div>
        <div id="shopping-cart"><a><i class="fas fa-shopping-cart"></i> Cart</a></div>
        <?php if ($loggedIn): ?>
            <div id="user-profile-container">
                <div id="user-avatar"><?= strtoupper($_SESSION['Name'][0]) ?></div>
                <div id="user-dropdown">
                    <i class="fa fa-caret-down"></i>
                    <div id="dropdown-content">
                        <a href="user_profile_view.php">My Profile</a>
                        <a href="user_profile_update.php">Edit Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </nav>
</header>

<div class="main">
    <div id="image-container">
        <img src="<?= $product['images'] ?>" alt="Product Image" id="product-image" />
    </div>
    <div id="right-desc">
        <div id="product-box">
            <h2 id="product-name"><?= htmlspecialchars($product['Pname']) ?></h2>
            <h3 id="product-price"><i class="fas fa-tag"></i> ₹<?= $product['Price'] ?></h3>
        </div>
        <div id="discription"><?= nl2br(htmlspecialchars($product['specifications'])) ?></div>
        <div id="Specification">
            <h3>Specification</h3>
            <ul>
                <li>Category: Electronics</li>
                <li>Origin: India</li>
            </ul>
        </div>
        <button id="Add-to-cart"
            onclick='handleAddToCart(<?= json_encode([
                "pid" => $product["Pid"],
                "name" => $product["Pname"],
                "image" => $product["images"],
                "price" => $product["Price"]
            ]) ?>)'>Add to Cart</button>
    </div>
</div>

<!-- Cart Panel -->
<div id="cart-content">
    <i class="fa fa-times" id="close" style="cursor:pointer;"></i>
    <h2>Cart item</h2>
    <div class="cart-elem"></div>
    <div class="total">
        <div id="total-title">Total :</div>
        <div id="total-price">₹0</div>
    </div>
    <button id="check-out">Check-Out</button>
</div>

<script>
const isLoggedIn = <?= json_encode($loggedIn) ?>;

function handleAddToCart(product) {
    if (!isLoggedIn) {
        window.location.href = 'login.php';
        return;
    }

    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const existing = cart.find(item => item.pid === product.pid);
    if (existing) {
        existing.quantity += 1;
    } else {
        product.quantity = 1;
        cart.push(product);
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartUI();
    fetch("update_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "cart_data=" + encodeURIComponent(JSON.stringify(cart))
    });
}

function updateCartUI() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const container = document.querySelector(".cart-elem");
    const totalPrice = document.getElementById("total-price");
    container.innerHTML = "";
    let total = 0;
    cart.forEach((item, i) => {
        total += item.price * item.quantity;
        container.innerHTML += `
            <div class="cart-item" style="display:flex; align-items:center; margin-bottom:10px;">
                <img src="${item.image}" />
                <div>
                    <b>${item.name}</b><br>₹${item.price} × ${item.quantity}
                    <button onclick="removeItem(${i})" style="margin-left:5px;">Remove</button>
                </div>
            </div>`;
    });
    totalPrice.innerText = "₹" + total;
}

function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartUI();
    fetch("update_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "cart_data=" + encodeURIComponent(JSON.stringify(cart))
    });
}

document.getElementById("shopping-cart").onclick = () => {
    document.getElementById("cart-content").style.right = "0";
};
document.getElementById("close").onclick = () => {
    document.getElementById("cart-content").style.right = "-100%";
};
document.getElementById("check-out").onclick = () => {
    var form = document.createElement('form');
    form.style.visibility = 'hidden';
    form.method = 'POST';
    form.action = 'delivery_request.php';

    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'cart_data';
    input.value = JSON.stringify(JSON.parse(localStorage.getItem('cart') || '[]'));

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
};

updateCartUI();
</script>
<script src="app.js"></script>
</body>
</html>
