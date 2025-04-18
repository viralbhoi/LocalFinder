<?php
require_once "pdo.php";
session_start();

// Verify Vendor Login
if (!isset($_SESSION['Name'])) {
    header('Location:./login.php');  // Redirect to login if not logged in
    return;
}

$vendor_id = $_SESSION['Id'];

// Fetch vendor's existing profile data
$sql = "SELECT v.Vname, s.Sname, s.Address_line1, s.District, s.Pincode, s.State, GROUP_CONCAT(p.Pname) AS products
        FROM vendor v
        JOIN shop s ON v.Vid = s.Vid
        LEFT JOIN link_product_to_shop l ON s.Sid = l.Sid
        LEFT JOIN product p ON l.Pid = p.Pid
        WHERE v.Vid = :Vid
        GROUP BY v.Vid, s.Sid";

$stmt = $pdo->prepare($sql);
$stmt->execute([':Vid' => $vendor_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile update submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $owner_name = $_POST['name'];
    $shop_name = $_POST['shop-name'];
    $products = $_POST['products'];
    $location = $_POST['location'];

    try {
        // Update vendor and shop tables (example - adjust queries as needed)
        $sql_vendor = "UPDATE vendor SET Vname = :Vname WHERE Vid = :Vid";
        $stmt_vendor = $pdo->prepare($sql_vendor);
        $stmt_vendor->execute([':Vname' => $owner_name, ':Vid' => $vendor_id]);

        $sql_shop = "UPDATE shop SET Sname = :Sname, Address_line1 = :Address_line1 WHERE Vid = :Vid";
        $stmt_shop = $pdo->prepare($sql_shop);
        $stmt_shop->execute([':Sname' => $shop_name, ':Address_line1' => $location, ':Vid' => $vendor_id]);

        // Update the product list (this is a simplified example - you might need a more robust solution)
        $product_array = explode(",", $products);
        // Delete existing products for shop and add again
        $sql_delete_products = "DELETE FROM link_product_to_shop WHERE Sid = (SELECT Sid FROM shop WHERE Vid = :Vid)";
        $stmt_delete_products = $pdo->prepare($sql_delete_products);
        $stmt_delete_products->execute([':Vid' => $vendor_id]);

        foreach ($product_array as $product_name) {
           // Check if product exists. If not create a product
           $sql_product_exists = "SELECT COUNT(*) FROM product WHERE Pname = :Pname";
           $stmt_product_exists = $pdo->prepare($sql_product_exists);
           $stmt_product_exists->execute([':Pname' => $product_name]);
           $product_exists = $stmt_product_exists->fetchColumn();

           if($product_exists == 0) {
             $sql_create_product = "INSERT INTO product (Pid, Pname, images) VALUES (UUID(), :Pname, 'default.jpg')";
             $stmt_create_product = $pdo->prepare($sql_create_product);
             $stmt_create_product->execute([':Pname' => $product_name]);
           }
           // Link products to the shop
           $sql_link_product = "INSERT INTO link_product_to_shop (Pid, Sid) SELECT (SELECT Pid FROM product WHERE Pname = :Pname), (SELECT Sid FROM shop WHERE Vid = :Vid)";
           $stmt_link_product = $pdo->prepare($sql_link_product);
           $stmt_link_product->execute([':Pname' => $product_name, ':Vid' => $vendor_id]);
        }

        echo "Profile updated successfully!";
    } catch (PDOException $e) {
        echo "Error updating profile: " . $e->getMessage();
    }

     // Refresh vendor's existing profile data
    $sql = "SELECT v.Vname, s.Sname, s.Address_line1, s.District, s.Pincode, s.State, GROUP_CONCAT(p.Pname) AS products
            FROM vendor v
            JOIN shop s ON v.Vid = s.Vid
            LEFT JOIN link_product_to_shop l ON s.Sid = l.Sid
            LEFT JOIN product p ON l.Pid = p.Pid
            WHERE v.Vid = :Vid
            GROUP BY v.Vid, s.Sid";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':Vid' => $vendor_id]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Local Finder - Update Vendor Profile</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
    <header>
        <div id="logo_1"></div>
        <div>
            <nav>
                <div><a href="about.php">About Us</a></div>
                <div><a href="contact.php">Contact Us</a></div>
                <div><a href="vendor_dashboard.php">Dashboard</a></div>
            </nav>
            <div align="right"></div>
            <div class="set-location">
            </div>
            <div id="search-box" required>
                <i class="fas fa-search"></i>
                <input type="text" id="search" placeholder="Search...">
            </div>
        </div>
    </header>
    <h1>Update Profile</h1>

    <form method="POST">
        <label for="name">Owner Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($profile['Vname']) ?>" required>

        <label for="shop-name">Shop Name:</label>
        <input type="text" id="shop-name" name="shop-name" value="<?= htmlspecialchars($profile['Sname']) ?>" required>

        <label for="products">Products (comma-separated):</label>
        <textarea id="products" name="products" placeholder="e.g.: product1, product2..." required><?= htmlspecialchars($profile['products']) ?></textarea>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?= htmlspecialchars($profile['Address_line1']) ?>" required>

        <input type="submit" value="Update Profile">
    </form>
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
