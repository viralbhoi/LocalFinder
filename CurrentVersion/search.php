<?php
session_start();
require_once "pdo.php";

$loggedIn = isset($_SESSION['Name']);
$cart = $_SESSION['cartData'] ?? [];

$results = [];
if (isset($_GET['query'], $_GET['location'])) {
    $searchQuery = $_GET['query'];
    $location = $_GET['location'];

    try {
        $stmt = $pdo->prepare("
            SELECT p.* FROM product p
            JOIN link_product_to_shop lps ON p.Pid = lps.Pid
            JOIN shop s ON lps.Sid = s.Sid
            WHERE p.Pname LIKE :query AND s.District = :location
        ");
        $stmt->execute([':query' => "%$searchQuery%", ':location' => $location]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Search Error: " . $e->getMessage());
    }
}

$loggedIn = isset($_SESSION['Name']);
echo "<script>let logged_in = " . ($loggedIn ? "true" : "false") . ";</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Search Results</title>
    <link rel="stylesheet" href="styles/style1.css" />
    <link rel="stylesheet" href="styles/style.css" />
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
        #user-dropdown {
            position: relative;
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
        #dropdown-content a {
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            white-space: nowrap;
        }
        #dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .cart-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin-right: 10px;
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
    </style>
</head>
<body>

<header>
    <div id="logo_1" onclick="window.location.href='index.php'"></div>
    <nav>
        <div class="before_login"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></div>
        <div class="before_login"><a href="user_reg.php"><i class="fas fa-user-plus"></i> Register</a></div>
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
                        <a href="user_profile_update.php">Edit</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </nav>
</header>

<h2 align="center">Search Results</h2>

<div id="product-container">
    <?php if ($results): ?>
        <?php foreach ($results as $result): ?>
            <div class="product">
                <a href="product1.php?pid=<?= htmlspecialchars($result['Pid']) ?>">
                    <img class="pic" src="<?= htmlspecialchars($result['images']) ?>" alt="<?= htmlspecialchars($result['Pname']) ?>">
                    <div class="description">
                        <h6><?= htmlspecialchars($result['Pname']) ?></h6>
                        <p><?= htmlspecialchars($result['specifications']) ?></p>
                        <b>Price: ₹<?= htmlspecialchars($result['Price']) ?></b>
                    </div>
                </a>
                <button class="add-to-cart-btn"
                    onclick='handleAddToCart(<?= json_encode([
                        "pid" => $result["Pid"],
                        "name" => $result["Pname"],
                        "image" => $result["images"],
                        "price" => $result["Price"]
                    ]) ?>)'>Add to Cart</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center;">No products found.</p>
    <?php endif; ?>
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
<script src="scripts/app.js"></script>
</body>
</html>
