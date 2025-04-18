<?php
session_start();

if (isset($_REQUEST['name'])) {
    require_once "pdo.php";
    
    // Use prepared statements for security
    $stmt = $pdo->prepare('SELECT * FROM product WHERE Pname = :name');
    $stmt->execute([':name' => $_REQUEST['name']]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Handle the case when 'name' is not provided
    $results = null;
}

// Increment product view count
function incrementProductView($pdo, $product_id) {
    $sql = "INSERT INTO product_views (Pid, view_date) VALUES (:Pid, CURDATE())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':Pid' => $product_id]);
}

if ($results) {
    foreach ($results as $result) {
        incrementProductView($pdo, $result['Pid']);
    }
}
?>

<?php

if (isset($_REQUEST['name'])) {
    require_once "pdo.php";
    
    // Use prepared statements for security
    $stmt = $pdo->prepare('SELECT * FROM product WHERE Pname = :name');
    $stmt->execute([':name' => $_REQUEST['name']]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Handle the case when 'name' is not provided
    $results = null;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>LocalFinder</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="scripts/app.js" type="text/javascript"></script>
    <script src="scripts/script1.js"></script>
    <style>
        #user-profile-container {
            display: inline-block;
            margin-top: 3px;
        }

        #user-avatar {
            background-color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 1px;
        }

        #user-dropdown {
            display: inline-block;
            margin-left: 5px;
            position: relative;
        }
    </style>
</head>

<body>
    <section id="first_page">
        <header>
            <a href=" "><div id="logo_1"></div></a>
            <div>
                <nav>
                    <div class="before_login"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Log In</a></div>
                    <div class="before_login"><a href="user_reg.php"><i class="fas fa-user-plus"></i> Register</a></div>
                    <div><a href="about.php"><i class="fas fa-info-circle"></i> About Us</a></div>
                    <div><a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a></div>
                    <div class="after_login"><a href="delivery_request.html"><i class="fas fa-truck"></i> Delivery Request</a></div>
                </nav>
            </div>
        </header>

        <div id="container1">
            <?php if (isset($_SESSION['Name'])): ?>
                <div id="user-profile-container">
                    <div id="user-avatar">
                        <?= htmlspecialchars($_SESSION['Name'][0]) ?>
                    </div>
                    <div id="user-dropdown">
                        <i id="log1" class="fa fa-caret-down"></i>
                        <div id="dropdown-content" class="dropdown-content">
                            <a href="logout.php">Logout</a>
                            <a href="user_profile_view.php">User Profile</a>
                            <a href="user_profile_update.php">Edit Profile</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <section class="Advertise"></section>
    <section class="main-content">
        <section class="search_output">
            <h2>Search Results:</h2>
            <?php if ($results): ?>
                <?php foreach($results as $result): ?>
                    <a href="product.php?name=<?= htmlspecialchars($result['Pname']) ?>">
                        <div class="product">
                            <img class="pic" src="<?= htmlspecialchars($result['images']) ?>" alt="<?= htmlspecialchars($result['Pname']) ?>">
                            <div class="description">
                                <h6><?= htmlspecialchars($result['Pname']) ?></h6>
                                <p><?= htmlspecialchars($result['specifications']) ?></p>
                            </div>
                            <b>Price: <?= htmlspecialchars($result['Price']) ?></b>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Sorry, couldn't fetch product data.</p>
            <?php endif; ?>
        </section>
        <p align="center">& MANY MORE...</p>
        <section class="additional"></section>
    </section>
    <footer>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <div class="copyright">&copy; 2025 LocalFinder. All rights reserved.</div>
    </footer>
</body>

</html>
