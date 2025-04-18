<?php
require_once "pdo.php";

// Sanitize the search query (important for security!)
$search_query = isset($_GET['search']) ? filter_var($_GET['search'], FILTER_SANITIZE_STRING) : '';

// SQL query to search for products
$sql = "SELECT p.Pid, p.Pname, p.specifications, p.Price, p.images,
               s.Sname AS ShopName, v.Vname AS VendorName
        FROM product p
        JOIN link_product_to_shop l ON p.Pid = l.Pid
        JOIN shop s ON l.Sid = s.Sid
        JOIN vendor v ON s.Vid = v.Vid
        WHERE p.Pname LIKE :search_term"; // Use LIKE for partial matches

$stmt = $pdo->prepare($sql);
$stmt->execute([':search_term' => '%' . $search_query . '%']); // Add wildcards for LIKE
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/app.js" type="text/javascript"></script>
    <script src="scripts/script1.js"></script>
</head>

<body>
    <section id="first_page">
        <header>
            <div id="logo_1"></div>
            <div>
                <nav>
                    <div class="before_login"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Log In</a></div>
                    <div class="before_login"><a href="user_reg.php"><i class="fas fa-user-plus"></i> Register</a></div>
                    <div><a href="about.php"><i class="fas fa-info-circle"></i> About Us</a></div>
                    <div><a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a></div>
                    <div><a href="discuss.php"><i class="fas fa-comments"></i> Discuss</a></div>
                    <div class="after_login"><a href="delivery_request.php"><i class="fas fa-truck"></i> Delivery Request</a></div>
                </nav>
            </div>
            <div id="Left">

                <select name="locate" id="locate">
                    <option value="Anand">Anand</option>
                </select>
                <div id="search_box">
                  <i class="fas fa-search"></i>
                  <form action="search_eg.php" method="GET">
                    <input type="text" id="search" name="search" placeholder="Search..." value="<?= htmlspecialchars($search_query) ?>"/>
                  </form>
                </div>
            </div>
        </header>
    <section class="search-results">
        <h2>Search Results for "<?= htmlspecialchars($search_query) ?>"</h2>

        <div class="product-listings">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['images']) ?>" alt="<?= htmlspecialchars($product['Pname']) ?>">
                    <h3><?= htmlspecialchars($product['Pname']) ?></h3>
                    <p>Vendor: <?= htmlspecialchars($product['VendorName']) ?> (<?= htmlspecialchars($product['ShopName']) ?>)</p>
                    <p>Description: <?= htmlspecialchars($product['specifications']) ?></p>
                    <p>Price: $<?= htmlspecialchars($product['Price']) ?></p>
                    <button id="sub1">Order</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found matching your search.</p>
        <?php endif; ?>
        </div>
    </section>

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
