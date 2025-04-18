<?php
session_start();
require_once "pdo.php";

// Fetch 3 products
try {
    $stmt = $pdo->prepare('SELECT * FROM product LIMIT 3');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $results = [];
}

$loggedIn = isset($_SESSION['Name']);
echo "<script>let logged_in = " . ($loggedIn ? "true" : "false") . ";</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LocalFinder</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style1.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
    </style>
</head>
<body>
    <section id="first_page">
        <header>
            <div id="logo_1"></div>
            <nav>
                <div class="before_login"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Log In</a></div>
                <div class="before_login"><a href="user_reg.php"><i class="fas fa-user-plus"></i> Register</a></div>
                <div><a href="about.php"><i class="fas fa-info-circle"></i> About Us</a></div>
                <div><a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a></div>

                <?php if ($loggedIn): ?>
                <div id="user-profile-container" class="after_login">
                    <div id="user-avatar"><?= htmlspecialchars(strtoupper($_SESSION['Name'][0])) ?></div>
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

        <div id="container">
            <div id="brand_name">
                <h1>Local<br>Finder</h1>
                <p>Find in your locality</p>
            </div>
            <div id="Left">
                <select name="locate" id="locate">
                    <?php
                    try {
                        $stmt = $pdo->query("SELECT DISTINCT District FROM shop");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $city = htmlspecialchars($row['District']);
                            echo "<option value=\"$city\">$city</option>";
                        }
                    } catch (PDOException $e) {
                        echo "<option disabled>Error loading cities</option>";
                        error_log("City fetch error: " . $e->getMessage());
                    }
                    ?>
                </select>

                <div id="search_box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search" placeholder="Search..." />
                </div>
            </div>
        </div>
    </section>

    <section class="brief">
        <p align="center"><em>LocalFinder is a website for finding products in your own locality.</em></p>
    </section>

    <section class="main-content">
        <section class="recommendations">
            <?php if ($results): ?>
                <?php foreach ($results as $result): ?>
                    <a href="product1.php?pid=<?= htmlspecialchars($result['Pid']) ?>">
                        <div class="product">
                            <img class="pic" src="<?= htmlspecialchars($result['images']) ?>" alt="<?= htmlspecialchars($result['Pname']) ?>">
                            <div class="description">
                                <h6><?= htmlspecialchars($result['Pname']) ?></h6>
                                <p><?= htmlspecialchars($result['specifications']) ?></p>
                            </div>
                            <b>Price: ₹<?= htmlspecialchars($result['Price']) ?></b>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </section>
        <p align="center">& MANY MORE...</p>
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

    <script src="scripts/app.js"></script>
</body>
</html>
